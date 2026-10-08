# Final Project: ระบบแจ้งซ่อมและติดตามงานซ่อมออนไลน์

โปรเจกต์ Final Project สำหรับทำงาน 2 คน พัฒนาด้วย PHP 8+, MySQL, Bootstrap 5 และ PDO

## สมาชิกและการแบ่งงาน

### สมาชิกคนที่ 1 — ระบบผู้แจ้งและ Admin
- Login / Session
- แจ้งซ่อม
- อัปโหลดรูปก่อนซ่อม
- ดูรายการแจ้งซ่อม
- Dashboard
- จัดการผู้ใช้
- ดูงานทั้งหมด
- รายงานและพิมพ์

### สมาชิกคนที่ 2 — ระบบช่าง
- Dashboard ช่าง
- ดูงานที่รอรับ
- รับงาน
- เริ่มงาน
- บันทึกผลการซ่อม
- บันทึกค่าใช้จ่าย
- อัปโหลดรูปหลังซ่อม
- ติดตามสถานะงาน

## ความต้องการ
- XAMPP
- PHP 8.0 ขึ้นไป
- MySQL / MariaDB
- Web Browser

## วิธีติดตั้ง

1. แตกโฟลเดอร์ `final_repair_system_2person` ไปไว้ใน `C:\xampp\htdocs\`
2. เปิด XAMPP และ Start Apache + MySQL
3. เข้า phpMyAdmin
4. Import ไฟล์ `database/repair_system.sql`
5. เปิด `config/config.php` ตรวจสอบ host, database, username, password
6. เปิดเว็บไซต์:
   `http://localhost/final_repair_system_2person/`

## บัญชีตัวอย่าง
- admin / password
- teacher / password
- tech / password

## Workflow
pending → accepted → in_progress → completed

## หมายเหตุ
โฟลเดอร์ `uploads` ใช้เก็บรูปก่อนและหลังซ่อม ควรตรวจสอบชนิดไฟล์และขนาดไฟล์ก่อนใช้งานจริง

## โครงสร้างหลัก
- `admin/` ระบบผู้ดูแล
- `technician/` ระบบช่าง
- `user/` ระบบผู้แจ้ง
- `database/` SQL
- `config/` การเชื่อมต่อฐานข้อมูล
- `includes/` Header/Footer
- `assets/` CSS/JavaScript
- `uploads/` รูปภาพ


## 🔑 บัญชีสำหรับทดสอบ (เวอร์ชันแก้ไข)
- Admin: `admin` / `123456`
- User: `teacher` / `123456`
- Technician: `tech` / `123456`

### ถ้ามีฐานข้อมูลเดิมและล็อกอินไม่ได้
เข้า phpMyAdmin → เลือก `repair_system` → SQL → เปิดไฟล์ `database/reset_passwords.sql` แล้วนำ SQL ไปวางและกด Go/ดำเนินการ จากนั้นลองเข้าสู่ระบบใหม่
