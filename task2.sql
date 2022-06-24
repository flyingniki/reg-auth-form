SELECT `email` FROM users GROUP BY `email` HAVING COUNT (`email`)>1;

SELECT `login` FROM users WHERE `users.id` NOT IN (SELECT `user_id` FROM orders);

SELECT `login` FROM users WHERE `users.id` IN (SELECT `user_id` FROM orders GROUP BY `user_id` HAVING COUNT (*)>2);