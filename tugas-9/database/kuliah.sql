CREATE DATABASE IF NOT EXISTS kuliah;
USE kuliah;

-- ============================================================
--  1. USERS TABLE (autentikasi Laravel Breeze)
-- ============================================================
CREATE TABLE IF NOT EXISTS users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ============================================================
--  2. JADWALS TABLE
-- ============================================================
CREATE TABLE IF NOT EXISTS jadwals (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    mata_kuliah VARCHAR(255) NOT NULL,
    hari VARCHAR(50) NOT NULL,
    jam_mulai TIME NOT NULL,
    jam_selesai TIME NOT NULL,
    dosen VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ============================================================
--  3. TUGAS TABLE
-- ============================================================
CREATE TABLE IF NOT EXISTS tugas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    deskripsi TEXT NULL,
    deadline DATE NOT NULL,
    status VARCHAR(50) DEFAULT 'Belum Selesai',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ============================================================
--  4. MIGRATIONS TABLE (Laravel internal)
-- ============================================================
CREATE TABLE IF NOT EXISTS migrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    migration VARCHAR(255) NOT NULL,
    batch INT NOT NULL
);

-- ============================================================
--  5. SAMPLE DATA
-- ============================================================

INSERT INTO jadwals (mata_kuliah, hari, jam_mulai, jam_selesai, dosen, created_at, updated_at) VALUES
('Praktikum Metnum', 'Senin', '08:00:00', '09:40:00', 'Asprak', NOW(), NOW()),
('Praktikum Sisdat', 'Senin', '10:30:00', '12:10:00', 'Asprak', NOW(), NOW()),
('Pemweb', 'Senin', '13:30:00', '16:00:00', 'Pak Erick', NOW(), NOW()),
('Praktikum Pemweb', 'Senin', '16:00:00', '17:40:00', 'Asprak', NOW(), NOW()),
('Sistem Database I', 'Selasa', '07:30:00', '10:00:00', 'Pak Juli', NOW(), NOW()),
('Matematika Diskrit', 'Selasa', '10:30:00', '13:00:00', 'Pak Akik', NOW(), NOW()),
('Aljabar Linear', 'Selasa', '13:15:00', '15:45:00', 'Bu Silvia', NOW(), NOW()),
('PBO', 'Rabu', '07:30:00', '10:00:00', 'Pak Akmal', NOW(), NOW()),
('Entrepreneurship', 'Rabu', '10:30:00', '12:10:00', 'Pak R', NOW(), NOW()),
('Sistem Operasi', 'Rabu', '13:30:00', '16:00:00', 'Pak Rudi', NOW(), NOW()),
('Metnum', 'Kamis', '10:00:00', '12:30:00', 'Bu Helen', NOW(), NOW()),
('Praktikum PBO', 'Kamis', '16:00:00', '17:40:00', 'Asprak', NOW(), NOW());

INSERT INTO tugas (judul, deskripsi, deadline, status, created_at, updated_at) VALUES
('Tugas 7 Praktikum Pemweb', 'Membuat web CRUD sederhana menggunakan laravel', '2025-10-30', 'Belum Selesai', NOW(), NOW()),
('Tugas 7 Praktikum Metnum', 'Mengerjakan soal-soal metode numerik', '2025-10-26', 'Selesai', NOW(), NOW());