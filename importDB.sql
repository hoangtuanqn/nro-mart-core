INSERT INTO users (username, password, token, balance, role, banned, email, referral_code, daily_points, otp, ip_address, discount, total_spent, total_deposited, created_at, updated_at) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin_token', 100000, 'admin', 0, 'admin@example.com', 'ADMIN123', 100, '123456', '192.168.1.1', 10.0, 50000, 150000, NOW(), NOW()),
('user1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user1_token', 50000, 'member', 0, 'user1@example.com', 'REF123', 50, '654321', '192.168.1.2', 5.0, 20000, 70000, NOW(), NOW()),
('user2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user2_token', 30000, 'member', 0, 'user2@example.com', 'REF456', 30, '987654', '192.168.1.3', 3.0, 10000, 40000, NOW(), NOW()),
('user3', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user3_token', 20000, 'member', 1, 'user3@example.com', 'REF789', 20, '456789', '192.168.1.4', 2.0, 5000, 25000, NOW(), NOW()),
('user4', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user4_token', 10000, 'member', 0, 'user4@example.com', 'REF012', 10, '321654', '192.168.1.5', 1.0, 2000, 12000, NOW(), NOW());

INSERT INTO categories (name, display_status, image, created_at, updated_at) VALUES
('GAME', 'SHOW', 'game.jpg', NOW(), NOW()),
('LUCKY', 'SHOW', 'lucky.jpg', NOW(), NOW()),
('SERVICE', 'SHOW', 'service.jpg', NOW(), NOW()),
('GAME', 'HIDE', 'game_hidden.jpg', NOW(), NOW()),
('SERVICE', 'HIDE', 'service_hidden.jpg', NOW(), NOW());

INSERT INTO sub_categories (category_id, title, display_status, image, created_at, updated_at) VALUES
(1, 'Ngọc Rồng Online', 'SHOW', 'nro.jpg', NOW(), NOW()),
(1, 'Liên Quân Mobile', 'SHOW', 'lq.jpg', NOW(), NOW()),
(2, 'Vòng quay may mắn', 'SHOW', 'vqmn.jpg', NOW(), NOW()),
(3, 'Nạp game', 'SHOW', 'napgame.jpg', NOW(), NOW()),
(1, 'FIFA Online', 'HIDE', 'fifa.jpg', NOW(), NOW());

INSERT INTO game_accounts (sub_category_id, login_account, login_password, details, buyer_username, receiver, transaction_time, title, thumbnail, price, image_list, collaborator, status, server, planet, created_at, updated_at) VALUES
(1, 'nro_account1', 'nro_pass1', 'Tài khoản VIP 100 tỉ sức mạnh', 'user1', 'Người nhận 1', '2023-05-01 10:00:00', 'NRO VIP 100 tỉ', 'nro1.jpg', 500000, '["nro1_1.jpg","nro1_2.jpg"]', 'ctv1', 'sold', 1, 'Xayda', NOW(), NOW()),
(1, 'nro_account2', 'nro_pass2', 'Tài khoản 50 tỉ sức mạnh', NULL, NULL, NULL, 'NRO 50 tỉ', 'nro2.jpg', 250000, '["nro2_1.jpg"]', NULL, 'available', 2, 'TraiDat', NOW(), NOW()),
(2, 'lq_account1', 'lq_pass1', 'Tướng full skin', 'user2', 'Người nhận 2', '2023-05-02 11:00:00', 'LQ Full skin', 'lq1.jpg', 1000000, '["lq1_1.jpg","lq1_2.jpg","lq1_3.jpg"]', 'ctv2', 'sold', NULL, NULL, NOW(), NOW()),
(1, 'nro_account3', 'nro_pass3', 'Tài khoản mới chơi', NULL, NULL, NULL, 'NRO newbie', 'nro3.jpg', 50000, '[]', NULL, 'available', 3, 'Namek', NOW(), NOW()),
(5, 'fifa_account1', 'fifa_pass1', 'Đội hình toàn sao', NULL, NULL, NULL, 'FIFA Ultimate Team', 'fifa1.jpg', 300000, '["fifa1_1.jpg"]', NULL, 'reserved', NULL, NULL, NOW(), NOW());

INSERT INTO game_services (sub_category_id, title, price, service_type, notes, created_at, updated_at) VALUES
(4, 'Nạp thẻ Ngọc Rồng', 100000, 'SELL_RESOURCE', 'Tỉ lệ 1:10.000 ngọc', NOW(), NOW()),
(4, 'Nạp thẻ Liên Quân', 50000, 'SELL_RESOURCE', 'Tỉ lệ 1:1.000 kim cương', NOW(), NOW()),
(3, 'Vòng quay may mắn', 20000, 'OTHER', 'Quay nhận quà giá trị', NOW(), NOW()),
(4, 'Thuê boost rank Liên Quân', 300000, 'OTHER', 'Boost từ Vàng lên Bạch Kim', NOW(), NOW()),
(3, 'Đổi thưởng điểm', 0, 'OTHER', 'Dùng điểm tích lũy đổi quà', NOW(), NOW());

INSERT INTO service_orders (username, service_id, server, game_account, game_password, amount, price, status, notes, collaborator, created_at, updated_at) VALUES
('user1', 1, 1, 'nro_user1', 'nro_pass123', 500000, 500000, 'completed', 'Nạp ngọc thành công', 'ctv1', NOW(), NOW()),
('user2', 2, NULL, 'lq_user2', 'lq_pass456', 200000, 200000, 'pending', 'Đang chờ xử lý', NULL, NOW(), NOW()),
('user3', 3, NULL, NULL, NULL, 50000, 50000, 'completed', 'Quay trúng 100k', 'ctv2', NOW(), NOW()),
('user1', 4, NULL, 'lq_user1', 'lq_pass789', 300000, 300000, 'canceled', 'Hủy do không có thời gian', NULL, NOW(), NOW()),
('user4', 5, NULL, NULL, NULL, 0, 0, 'completed', 'Đổi 100 điểm lấy quà', 'ctv3', NOW(), NOW());

INSERT INTO transactions (balance_before, amount_changed, balance_after, transaction_time, description, username, created_at, updated_at) VALUES
(0, 100000, 100000, NOW(), 'Nạp tiền lần đầu', 'user1', NOW(), NOW()),
(100000, -50000, 50000, NOW(), 'Mua tài khoản NRO', 'user1', NOW(), NOW()),
(0, 200000, 200000, NOW(), 'Nạp tiền từ thẻ', 'user2', NOW(), NOW()),
(200000, -100000, 100000, NOW(), 'Mua dịch vụ nạp game', 'user2', NOW(), NOW()),
(50000, 300000, 350000, NOW(), 'Nhận tiền hoàn lại', 'user1', NOW(), NOW());

INSERT INTO banks (account_number, account_holder, bank_name, branch, logo, notes, created_at, updated_at) VALUES
('123456789', 'NGUYEN VAN A', 'Vietcombank', 'Hà Nội', 'vcb.jpg', 'Chuyển khoản 24/7', NOW(), NOW()),
('987654321', 'TRAN THI B', 'Techcombank', 'TP.HCM', 'tcb.jpg', 'Ưu tiên chuyển nhanh', NOW(), NOW()),
('456123789', 'LE VAN C', 'MB Bank', 'Đà Nẵng', 'mbb.jpg', 'Chi nhánh chính', NOW(), NOW()),
('789456123', 'PHAM THI D', 'Vietinbank', 'Hải Phòng', 'vtb.jpg', 'Chỉ làm việc giờ hành chính', NOW(), NOW()),
('321654987', 'HOANG VAN E', 'BIDV', 'Cần Thơ', 'bidv.jpg', 'Phí chuyển tiền thấp', NOW(), NOW());

INSERT INTO bank_auto (transaction_id, description, amount, cumulative_balance, transaction_time, bank_sub_account_id, username, created_at, updated_at) VALUES
('TXN123', 'Nạp tiền tự động', 500000, 500000, NOW(), 'SUB123', 'user1', NOW(), NOW()),
('TXN456', 'Nạp tiền tự động', 200000, 700000, NOW(), 'SUB456', 'user2', NOW(), NOW()),
('TXN789', 'Nạp tiền tự động', 1000000, 1700000, NOW(), 'SUB789', 'user3', NOW(), NOW()),
('TXN012', 'Nạp tiền tự động', 300000, 2000000, NOW(), 'SUB012', 'user4', NOW(), NOW()),
('TXN345', 'Nạp tiền tự động', 150000, 2150000, NOW(), 'SUB345', 'user1', NOW(), NOW());

INSERT INTO cards (code, username, card_type, denomination, actual_amount, serial, pin, status, notes, created_at, updated_at) VALUES
('CARD001', 'user1', 'Viettel', 50000, 45000, 'SER123', 'PIN456', 'success', 'Thẻ hợp lệ', NOW(), NOW()),
('CARD002', 'user2', 'Mobifone', 100000, 90000, 'SER456', 'PIN789', 'success', 'Thẻ đã xử lý', NOW(), NOW()),
('CARD003', 'user3', 'Vinaphone', 200000, 180000, 'SER789', 'PIN012', 'pending', 'Đang chờ xử lý', NOW(), NOW()),
('CARD004', 'user1', 'Viettel', 50000, 0, 'SER012', 'PIN345', 'failed', 'Thẻ đã sử dụng', NOW(), NOW()),
('CARD005', 'user4', 'Zing', 100000, 95000, 'SER345', 'PIN678', 'success', 'Thẻ mới nạp', NOW(), NOW());


INSERT INTO momo (request_id, transaction_id, partner_id, partner_name, amount, comment, transaction_time, username, status, created_at, updated_at) VALUES
('REQ001', 'MOMO123', 'PARTNER1', 'Đối tác A', '500000', 'Nạp tiền user1', NOW(), 'user1', 'success', NOW(), NOW()),
('REQ002', 'MOMO456', 'PARTNER2', 'Đối tác B', '200000', 'Nạp tiền user2', NOW(), 'user2', 'success', NOW(), NOW()),
('REQ003', 'MOMO789', 'PARTNER1', 'Đối tác A', '1000000', 'Nạp tiền user3', NOW(), 'user3', 'pending', NOW(), NOW()),
('REQ004', 'MOMO012', 'PARTNER3', 'Đối tác C', '300000', 'Nạp tiền user4', NOW(), 'user4', 'failed', NOW(), NOW()),
('REQ005', 'MOMO345', 'PARTNER2', 'Đối tác B', '150000', 'Nạp tiền user1', NOW(), 'user1', 'success', NOW(), NOW());

INSERT INTO options (`key`, `value`, created_at, updated_at) VALUES
('site_name', 'GameShop', NOW(), NOW()),
('site_description', 'Cửa hàng tài khoản game và dịch vụ uy tín', NOW(), NOW()),
('exchange_rate', '1.0', NOW(), NOW()),
('maintenance_mode', '0', NOW(), NOW()),
('contact_email', 'support@gameshop.com', NOW(), NOW());