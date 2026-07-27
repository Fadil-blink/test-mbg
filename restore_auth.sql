SET NAMES utf8mb4;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL UNIQUE,
  `description` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `full_name` VARCHAR(150) NOT NULL,
  `phone` VARCHAR(20),
  `role_id` INT NOT NULL,
  `organization_id` INT,
  `is_active` BOOLEAN DEFAULT TRUE,
  `last_login` DATETIME,
  `last_ip` VARCHAR(45),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE RESTRICT,
  KEY `idx_email` (`email`),
  KEY `idx_username` (`username`),
  KEY `idx_is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO `roles` (`name`, `description`) VALUES
('admin_pusat', 'Administrator Pusat - Penuh akses ke semua modul'),
('auditor_pusat', 'Auditor Pusat - Monitoring nasional dan audit'),
('auditor_khusus', 'Auditor Khusus - Audit insidental'),
('manager_sppg', 'Manager SPPG - Kelola pesanan dan anggaran'),
('staf_sppg', 'Staf SPPG - Petugas operasional SPPG'),
('supplier', 'Supplier - Penjual komoditas'),
('admin_supplier', 'Admin Supplier - Kelola produk dan pesanan'),
('system', 'System - Akun sistem untuk automation');

INSERT IGNORE INTO `users` (`username`, `email`, `password_hash`, `full_name`, `phone`, `role_id`, `is_active`, `last_login`) VALUES
('admin_pusat', 'admin@pusat.go.id', MD5('password123'), 'Administrator Pusat', '081-2345-6789', 1, TRUE, NOW()),
('auditor_utama', 'budi.s@audit.go.id', MD5('password123'), 'Budi Santoso', '082-3456-7890', 2, TRUE, NOW()),
('sppg_surabaya', 'manager@sppg-surabaya.go.id', MD5('password123'), 'Drs. Ahmad Fauzi', '083-4567-8901', 4, TRUE, NOW()),
('supplier_maju', 'admin@tanimaju.com', MD5('password123'), 'CV. Tani Sejahtera', '085-5678-9012', 7, TRUE, NOW()),
('system_bot', 'system@mbgfix.local', MD5('system123'), 'System Automation', NULL, 8, TRUE, NULL);
