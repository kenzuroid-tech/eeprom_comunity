CREATE TYPE user_role AS ENUM ('admin', 'anggota');



ALTER TABLE members ADD COLUMN skills TEXT;

CREATE TABLE IF NOT EXISTS gallery (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    image_url TEXT NOT NULL,
    category VARCHAR(50),
    event_date DATE DEFAULT CURRENT_DATE,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS meetings (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    start_time TIME NOT NULL,
    location VARCHAR(100),
    description TEXT,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);

-- Tabel untuk mencatat kehadiran member
CREATE TABLE IF NOT EXISTS attendance (
    id SERIAL PRIMARY KEY,
    meeting_id INT REFERENCES meetings(id) ON DELETE CASCADE,
    user_id INT REFERENCES users(id) ON DELETE CASCADE,
    status VARCHAR(20) DEFAULT 'Hadir', -- Hadir, Izin, Alpa
    remarks TEXT, -- Alasan jika izin
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT unique_attendance UNIQUE(meeting_id, user_id)
);

CREATE TABLE IF NOT EXISTS announcements (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    category VARCHAR(50) DEFAULT 'Umum',
    author VARCHAR(100) DEFAULT 'Admin',
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);

-- Mempercepat pencarian user berdasarkan email atau username saat login
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_username ON users(username);

-- Mempercepat pencarian profil member berdasarkan NIM
CREATE INDEX idx_members_nim ON members(nim);

INSERT INTO users (username, email, password, role) VALUES ('nisho', 'nisho@gmail.com', '$2y$10$examplehashedpassword', 'anggota');
INSERT INTO members (user_id, nama_lengkap, nim) VALUES (1, 'Nikmatus Sholihah', '244107020014');

-- Hapus data lama
DELETE FROM members WHERE user_id IN (SELECT id FROM users WHERE username = 'nisho');
DELETE FROM users WHERE username = 'nisho';

-- Insert user baru dengan password yang benar
INSERT INTO users (username, email, password, role, is_active) 
VALUES ('nisho', 'nisho@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'anggota', TRUE);

-- Insert member (ambil user_id otomatis)
INSERT INTO members (user_id, nama_lengkap, nim) 
VALUES ((SELECT id FROM users WHERE username = 'nisho'), 'Nikmatus Sholihah', '244107020014');

UPDATE users 
SET password = '$2y$10$8v8vXh.7oO/m5oD1RkHIOuN1Xv7.L7f9l.xJ/z3S5p7Q0eX9zR1S.' 
WHERE username = 'nisho';

UPDATE members 
SET 
    prodi = 'D4 Teknik Informatika', 
    angkatan = 24, 
    generasi = 16, 
    divisi = 'Software', 
    jabatan = 'Anggota'
WHERE user_id = 2;

