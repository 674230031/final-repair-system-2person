USE repair_system;

-- รีเซ็ตรหัสผ่านบัญชีตัวอย่างทั้งหมดเป็น 123456
UPDATE users SET password = '$2y$12$sPyA8oltGEtymqbaMx.KNuG.SVjJ0PpJdw3rOT0bXoVXAE4PDc0Z2' WHERE username = 'admin';
UPDATE users SET password = '$2y$12$dwj8.s95iYaKDp54cbayROybQPrfcdZ5NdZyy6iDPh3wqlcO1.XFy' WHERE username = 'teacher';
UPDATE users SET password = '$2y$12$kxuYL0bmmYq0gSjqq/BjVO/WpOIrZpt025QqjoTMiN3pRwIaiZrGy' WHERE username = 'tech';

-- หลังรันแล้วใช้:
-- admin / 123456
-- teacher / 123456
-- tech / 123456
