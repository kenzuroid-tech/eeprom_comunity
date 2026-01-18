-- Definisi Role Pengguna
DO $$ BEGIN
    CREATE TYPE user_role AS ENUM ('superadmin', 'admin', 'anggota');
EXCEPTION
    WHEN duplicate_object THEN null;
END $$;

CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role user_role DEFAULT 'anggota',
    last_login TIMESTAMPTZ,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS members (
    id SERIAL PRIMARY KEY,
    user_id INT UNIQUE REFERENCES users(id) ON DELETE CASCADE,
    nama_lengkap VARCHAR(150) NOT NULL,
    nim VARCHAR(20) NOT NULL UNIQUE,
    prodi VARCHAR(50),
    angkatan INT,
    generasi INT,
    divisi VARCHAR(50),
    jabatan VARCHAR(50) DEFAULT 'Anggota',
    status_keanggotaan VARCHAR(20) DEFAULT 'Active', -- Active, Alumni, Non-Active
    skills TEXT,
    foto_url TEXT,
    bio TEXT,
    social_links JSONB,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);

-- Indeks untuk performa
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_username ON users(username);
CREATE INDEX idx_members_nim ON members(nim);

CREATE TABLE IF NOT EXISTS divisions (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    icon TEXT DEFAULT '📁',
    description TEXT,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS organization_info (
    id SERIAL PRIMARY KEY,
    about_text TEXT,
    history_text TEXT,
    established_year INT DEFAULT 2015,
    vision TEXT,
    mission TEXT,
    motto TEXT,
    updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS organization_contact (
    id SERIAL PRIMARY KEY,
    address TEXT,
    email VARCHAR(100),
    phone VARCHAR(20),
    whatsapp VARCHAR(20),
    instagram VARCHAR(100),
    maps_code TEXT
);

CREATE TABLE IF NOT EXISTS contact_persons (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    position VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    photo_url TEXT,
    sort_order INT DEFAULT 0
);

CREATE TABLE IF NOT EXISTS meetings (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    start_time TIME NOT NULL,
    location VARCHAR(100),
    description TEXT,
    notulensi TEXT,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS attendance (
    id SERIAL PRIMARY KEY,
    meeting_id INT REFERENCES meetings(id) ON DELETE CASCADE,
    user_id INT REFERENCES users(id) ON DELETE CASCADE,
    status VARCHAR(20) DEFAULT 'Hadir', -- Hadir, Izin, Alpa
    remarks TEXT,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT unique_attendance UNIQUE(meeting_id, user_id)
);

CREATE TABLE IF NOT EXISTS activities (
    id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(id) ON DELETE CASCADE,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    type VARCHAR(50), -- Update, Insert, Delete, Info
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS forum_posts (
    id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(id) ON DELETE CASCADE,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    category VARCHAR(50),
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS forum_comments (
    id SERIAL PRIMARY KEY,
    post_id INT REFERENCES forum_posts(id) ON DELETE CASCADE,
    user_id INT REFERENCES users(id) ON DELETE CASCADE,
    comment TEXT NOT NULL,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS announcements (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    category VARCHAR(50) DEFAULT 'info',
    author VARCHAR(100) DEFAULT 'Admin',
    status VARCHAR(20) DEFAULT 'Draft',
    updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS gallery (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    image_url TEXT NOT NULL,
    category VARCHAR(50),
    event_date DATE DEFAULT CURRENT_DATE,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS documents (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(50), -- SOP, Forms, Reports, Guidelines
    file_size VARCHAR(20),
    file_url TEXT NOT NULL,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    uploaded_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS achievements (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    rank VARCHAR(100),
    event_name VARCHAR(255),
    year INT,
    description TEXT,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);

-- Modul Rekrutmen
CREATE TABLE IF NOT EXISTS recruitment_periods (
    id SERIAL PRIMARY KEY,
    nama_periode VARCHAR(100) NOT NULL,
    semester VARCHAR(10) CHECK (semester IN ('Ganjil', 'Genap')),
    tahun_akademik VARCHAR(20),
    tanggal_mulai DATE NOT NULL,
    tanggal_selesai DATE NOT NULL,
    status VARCHAR(20) DEFAULT 'Draft' CHECK (status IN ('Active', 'Closed', 'Draft')),
    description TEXT,
    requirements TEXT,
    timeline TEXT,
    opened_divisions TEXT,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS applicants (
    id SERIAL PRIMARY KEY,
    period_id INT REFERENCES recruitment_periods(id) ON DELETE CASCADE,
    nama_lengkap VARCHAR(150) NOT NULL,
    nim VARCHAR(20) NOT NULL UNIQUE,
    prodi VARCHAR(50),
    email VARCHAR(100),
    whatsapp VARCHAR(20),
    divisi_pilihan_1 VARCHAR(50),
    divisi_pilihan_2 VARCHAR(50),
    berkas_url TEXT,
    status VARCHAR(20) DEFAULT 'Pending' CHECK (status IN ('Pending', 'Accepted', 'Rejected')),
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);

-- Modul Pemilihan (Election)
CREATE TABLE IF NOT EXISTS elections (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    start_date TIMESTAMPTZ NOT NULL,
    end_date TIMESTAMPTZ NOT NULL,
    status VARCHAR(20) DEFAULT 'Draft',
    allow_all_active BOOLEAN DEFAULT TRUE,
    eligible_generations JSONB,
    show_realtime_admin BOOLEAN DEFAULT TRUE,
    show_result_voter BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS candidates (
    id SERIAL PRIMARY KEY,
    election_id INT REFERENCES elections(id) ON DELETE CASCADE,
    name VARCHAR(150) NOT NULL,
    nim VARCHAR(20) NOT NULL,
    generasi INT,
    divisi VARCHAR(50),
    visi TEXT,
    misi TEXT,
    photo_url TEXT,
    number_order INT,
    UNIQUE(election_id, number_order)
);

CREATE TABLE IF NOT EXISTS votes (
    id SERIAL PRIMARY KEY,
    election_id INT REFERENCES elections(id) ON DELETE CASCADE,
    user_id INT REFERENCES users(id) ON DELETE CASCADE,
    candidate_id INT REFERENCES candidates(id) ON DELETE CASCADE,
    voted_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT unique_user_per_election UNIQUE (user_id, election_id)
);

CREATE TABLE IF NOT EXISTS contacts (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255),
    message TEXT NOT NULL,
    status VARCHAR(20) DEFAULT 'unread',
    created_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS site_settings (
    id SERIAL PRIMARY KEY,
    site_name VARCHAR(255) DEFAULT 'EEPROM POLINEMA',
    maintenance_mode BOOLEAN DEFAULT FALSE,
    registration_open BOOLEAN DEFAULT TRUE,
    updated_at TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP
);