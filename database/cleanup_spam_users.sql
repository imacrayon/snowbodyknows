-- Remove spam user accounts and their associated data.
--
-- A user is considered spam if they have NEVER:
--   * created a wish (in any wishlist they own, including soft-deleted)
--   * created a wishlist besides the default one made at registration
--   * joined another user's wishlist (via the user_wishlist pivot)
--   * left a comment
--   * granted a wish (protective signal, not in the original criteria)
--   * joined a group (users coming in via an invite link land in group_user;
--     bots are coming through the public registration form, so any group
--     membership is treated as a signal of a real user)
--
-- Run inside a transaction. Swap COMMIT for ROLLBACK to dry-run.
-- Take a database snapshot before executing.

START TRANSACTION;

-- 1. Materialize the spam user set once.
CREATE TEMPORARY TABLE spam_users (id BIGINT UNSIGNED PRIMARY KEY);

INSERT INTO spam_users (id)
SELECT u.id
FROM users u
WHERE NOT EXISTS (
        SELECT 1 FROM comments c WHERE c.user_id = u.id
      )
  AND NOT EXISTS (
        SELECT 1 FROM wishes w
        JOIN wishlists wl ON wl.id = w.wishlist_id
        WHERE wl.user_id = u.id
      )
  AND NOT EXISTS (
        SELECT 1 FROM wishes w WHERE w.granter_id = u.id
      )
  AND NOT EXISTS (
        SELECT 1 FROM user_wishlist uw
        JOIN wishlists wl ON wl.id = uw.wishlist_id
        WHERE uw.user_id = u.id AND wl.user_id <> u.id
      )
  AND NOT EXISTS (
        SELECT 1 FROM group_user gu WHERE gu.user_id = u.id
      )
  AND (SELECT COUNT(*) FROM wishlists wl WHERE wl.user_id = u.id) <= 1;

-- 2. Materialize the (default) wishlists owned by those users.
CREATE TEMPORARY TABLE spam_wishlists (id BIGINT UNSIGNED PRIMARY KEY);

INSERT INTO spam_wishlists (id)
SELECT wl.id
FROM wishlists wl
JOIN spam_users su ON su.id = wl.user_id;

-- 3. Sanity preview (optional — inspect before committing).
SELECT
  (SELECT COUNT(*) FROM spam_users)     AS users_to_delete,
  (SELECT COUNT(*) FROM spam_wishlists) AS wishlists_to_delete;

-- 4. Remove dependent rows in FK order.

-- Comments left on the spam users' (default) wishlists by anyone.
DELETE c FROM comments c
JOIN spam_wishlists sw ON sw.id = c.commentable_id
WHERE c.commentable_type = 'wishlist';

-- Pivot rows referencing the spam users.
DELETE uw FROM user_wishlist uw JOIN spam_users su ON su.id = uw.user_id;
-- Pivot rows referencing the soon-to-be-deleted wishlists.
DELETE uw FROM user_wishlist uw JOIN spam_wishlists sw ON sw.id = uw.wishlist_id;
DELETE gw FROM group_wishlist gw JOIN spam_wishlists sw ON sw.id = gw.wishlist_id;
DELETE gu FROM group_user gu JOIN spam_users su ON su.id = gu.user_id;

-- Wishlists themselves (hard delete; SoftDeletes does not apply to raw SQL).
DELETE wl FROM wishlists wl JOIN spam_wishlists sw ON sw.id = wl.id;

-- Auth tokens.
DELETE pat FROM personal_access_tokens pat
JOIN spam_users su ON su.id = pat.tokenable_id
WHERE pat.tokenable_type = 'user';

DELETE prt FROM password_reset_tokens prt
JOIN users u ON u.email = prt.email
JOIN spam_users su ON su.id = u.id;

-- 5. Finally, the users.
DELETE u FROM users u JOIN spam_users su ON su.id = u.id;

DROP TEMPORARY TABLE spam_wishlists;
DROP TEMPORARY TABLE spam_users;

COMMIT;
