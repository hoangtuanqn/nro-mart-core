# HỆ THỐNG BÁN TÀI KHOẢN GAME NGỌC RỒNG ONLINE

## GIỚI THIỆU

Hệ thống bán tài khoản game Ngọc Rồng Online là một nền tảng thương mại điện tử chuyên nghiệp, được xây dựng trên Laravel Framework 10.x với PHP 8.1+. Dự án được phát triển bởi Tuấn Ori IT, hiện đang được triển khai và cung cấp cho khách hàng thực tế.

Website cung cấp đầy đủ các tính năng bán tài khoản game, dịch vụ game, vòng quay may mắn, nạp tiền, rút tiền và quản trị hệ thống hoàn chỉnh. Hệ thống được thiết kế để phục vụ cả người dùng cuối và quản trị viên với giao diện thân thiện, hiện đại.

## TRIỂN KHAI

- Liên kết website: [Shop Bán Acc Game Online](https://shopaccgame.tuanori.vn/)
- Giới thiệu sản phẩm: [SHARE CODE BÁN ACC GAME CỰC ĐẸP, AUTO ATM, CARD TỰ ĐỘNG, CÓ VÒNG QUAY MAY MẮN](https://youtu.be/n_RUQXYppgs?si=8MsJjP4SbfRBSona)

![Hình ảnh minh họa](https://i.ibb.co/XrPBmTJX/2025-12-08-012405.png)

## CÔNG NGHỆ SỬ DỤNG

- Backend Framework: Laravel 10.x
- PHP Version: 8.1 trở lên
- Database: MySQL/MariaDB
- Frontend: Blade Template Engine, TailwindCSS, JavaScript
- Authentication: Laravel Sanctum
- Social Login: Laravel Socialite (Google, Facebook)

## CẤU TRÚC DỰ ÁN

### Thư mục chính

```
shop-game-nro/
├── app/                      # Mã nguồn ứng dụng chính
│   ├── Console/             # Artisan commands
│   ├── Exceptions/          # Xử lý ngoại lệ
│   ├── Facades/             # Facades tùy chỉnh
│   ├── Helpers/             # Helper classes
│   ├── Http/                # Controllers, Middleware, Requests
│   ├── Mail/                # Email templates
│   ├── Models/              # Eloquent Models
│   ├── Notifications/       # Thông báo
│   ├── Providers/           # Service Providers
│   └── View/                # View Components
├── config/                  # File cấu hình
├── database/                # Migrations và Seeders
├── public/                  # Thư mục public
├── resources/               # Views, CSS, JS
├── routes/                  # Định nghĩa routes
└── storage/                 # File storage
```

## TÍNH NĂNG CHI TIẾT

### 1. HỆ THỐNG QUẢN LÝ NGƯỜI DÙNG

#### 1.1. Đăng ký và Đăng nhập

- Đăng ký tài khoản với username, email, password
- Đăng nhập bằng username/email và password
- Đăng nhập qua Google OAuth
- Đăng nhập qua Facebook OAuth
- Xác thực email sau khi đăng ký
- Quên mật khẩu và reset mật khẩu qua email
- Quản lý session và remember me
- Middleware bảo vệ routes theo role (admin/user)

#### 1.2. Quản lý Profile

- Xem thông tin tài khoản cá nhân
- Đổi mật khẩu với xác thực mật khẩu cũ
- Cập nhật avatar
- Hiển thị số dư tài khoản hiện tại
- Hiển thị tổng tiền đã nạp
- Theo dõi trạng thái tài khoản (banned/active)

#### 1.3. Phân quyền

- Role Admin: Toàn quyền quản trị hệ thống
- Role User: Người dùng thông thường, mua tài khoản và dịch vụ
- Middleware kiểm tra quyền truy cập cho từng route
- Bảo vệ các chức năng admin khỏi user thường

### 2. QUẢN LÝ TÀI KHOẢN GAME

#### 2.1. Danh mục tài khoản (Game Categories)

- Tạo, sửa, xóa danh mục tài khoản
- Mỗi danh mục có: tên, slug (SEO-friendly), ảnh thumbnail, mô tả
- Trạng thái active/inactive để ẩn/hiện danh mục
- Hiển thị danh sách tất cả danh mục cho người dùng
- Xem chi tiết từng danh mục với các tài khoản thuộc danh mục đó

#### 2.2. Tài khoản Game (Game Accounts)

Mỗi tài khoản game bao gồm các thông tin chi tiết:

**Thông tin cơ bản:**

- Tên tài khoản (account_name)
- Mật khẩu tài khoản
- Giá bán (price)
- Trạng thái: available (có sẵn), sold (đã bán), locked (khóa), pending (chờ xử lý)
- Liên kết với danh mục (game_category_id)

**Thông tin game cụ thể:**

- Máy chủ (server): từ 1 đến 13
- Hình thức đăng ký (registration_type): Ảo (virtual) hoặc Thật (real)
- Hành tinh (planet): Trái Đất (earth), Namek (namek), Xayda (xayda)
- Bông tai (earring): có/không
- Ghi chú thêm (note)
- Ảnh đại diện (thumb)
- Danh sách ảnh chi tiết (images)

**Chức năng quản lý:**

- Admin: Thêm, sửa, xóa tài khoản game
- Admin: Upload nhiều ảnh cho mỗi tài khoản
- Admin: Quản lý trạng thái tài khoản
- User: Xem danh sách tài khoản theo danh mục
- User: Xem chi tiết tài khoản với đầy đủ thông tin và ảnh
- User: Mua tài khoản (chuyển trạng thái sang sold)

#### 2.3. Lịch sử mua tài khoản

- Lưu trữ toàn bộ lịch sử mua tài khoản (purchase_history)
- Thông tin: người mua, tài khoản đã mua, giá tiền, thời gian
- User có thể xem lại danh sách tài khoản đã mua
- Admin xem tổng quan lịch sử mua bán

### 3. QUẢN LÝ TÀI KHOẢN RANDOM

#### 3.1. Danh mục Random (Random Categories)

- Tạo các danh mục tài khoản random với giá cố định
- Mỗi danh mục có: tên, slug, thumbnail, mô tả
- Trạng thái active/inactive
- Người dùng không biết tài khoản cụ thể trước khi mua

#### 3.2. Tài khoản Random (Random Category Accounts)

- Admin thêm nhiều tài khoản vào pool random
- Mỗi tài khoản thuộc một random_category_id
- Trạng thái: available, sold
- Khi user mua, hệ thống random chọn 1 tài khoản available
- Sau khi mua, tài khoản chuyển sang sold và gán cho user
- User có thể xem lịch sử mua tài khoản random

#### 3.3. Lịch sử mua Random

- Lưu trữ lịch sử mua tài khoản random (random_account_purchases)
- User xem được tài khoản random đã trúng
- Admin theo dõi doanh thu từ tài khoản random

### 4. HỆ THỐNG DỊCH VỤ GAME

#### 4.1. Danh sách dịch vụ (Game Services)

Hệ thống hỗ trợ nhiều loại dịch vụ game:

**Loại dịch vụ:**

- Bán vàng (gold)
- Bán ngọc (gem)
- Cày thuê (leveling)

**Thông tin dịch vụ:**

- Tên dịch vụ
- Slug (SEO-friendly URL)
- Ảnh thumbnail
- Mô tả chi tiết
- Trạng thái active/inactive

#### 4.2. Gói dịch vụ (Service Packages)

- Mỗi dịch vụ có nhiều gói với giá khác nhau
- Admin tạo, sửa, xóa các gói dịch vụ
- Thông tin gói: tên gói, giá tiền, mô tả
- Liên kết với game_service_id

#### 4.3. Đặt hàng dịch vụ (Service Orders)

**Quy trình đặt hàng:**

1. User chọn dịch vụ và gói
2. Nhập thông tin nhân vật game, máy chủ
3. Thanh toán bằng số dư tài khoản
4. Đơn hàng được tạo với trạng thái "processing"
5. Admin xử lý và cập nhật trạng thái

**Trạng thái đơn hàng:**

- processing: Đang xử lý
- success: Hoàn thành
- error: Thất bại

**Thông tin đơn hàng:**

- User ID
- Dịch vụ và gói đã chọn
- Tên nhân vật nhận
- Máy chủ
- Ghi chú của user
- Ghi chú của admin (khi xử lý)
- Trạng thái

#### 4.4. Lịch sử dịch vụ

- User: Xem lịch sử các dịch vụ đã đặt
- User: Xem chi tiết từng đơn dịch vụ
- Admin: Quản lý danh sách đơn hàng dịch vụ chờ xử lý
- Admin: Duyệt hoặc từ chối đơn hàng
- Admin: Thêm ghi chú khi xử lý

### 5. HỆ THỐNG VÒNG QUAY MAY MẮN

#### 5.1. Quản lý vòng quay (Lucky Wheels)

**Thông tin vòng quay:**

- Tên vòng quay
- Slug (URL SEO)
- Ảnh thumbnail
- Ảnh vòng quay (wheel_image)
- Mô tả
- Thể lệ chi tiết (rules)
- Giá mỗi lượt quay (price_per_spin)
- Trạng thái active/inactive

**Cấu hình phần thưởng:**

- Mỗi vòng quay có 8 phần thưởng
- Config lưu dạng JSON
- Mỗi phần thưởng gồm:
  - Loại (type): vàng hoặc ngọc
  - Nội dung hiển thị (content)
  - Số lượng trúng (amount)

#### 5.2. Quay thưởng

**Quy trình quay:**

1. User chọn vòng quay muốn tham gia
2. Hệ thống kiểm tra số dư (phải đủ price_per_spin)
3. Trừ tiền và thực hiện quay random
4. Random 1 trong 8 phần thưởng theo config
5. Cộng phần thưởng (vàng/ngọc) vào tài khoản
6. Lưu lịch sử quay

#### 5.3. Lịch sử vòng quay

- Lưu trữ toàn bộ lịch sử quay (lucky_wheel_histories)
- Thông tin: user, vòng quay, phần thưởng trúng, thời gian
- User xem lại lịch sử các lần quay của mình
- User xem chi tiết từng lần quay
- Admin xem tổng quan lịch sử vòng quay

### 6. HỆ THỐNG NẠP TIỀN

#### 6.1. Nạp tiền qua thẻ cào (Card Deposit)

**Thông tin giao dịch:**

- Nhà mạng (telco): Viettel, Vinaphone, Mobifone, etc.
- Mệnh giá (amount)
- Số tiền thực nhận (received_amount) - sau khi trừ phí
- Số serial thẻ
- Mã PIN thẻ
- Request ID (mã giao dịch)
- Trạng thái: processing, success, error
- Response từ hệ thống thanh toán

**Quy trình:**

1. User chọn nhà mạng và nhập thông tin thẻ
2. Gửi request đến API thanh toán
3. Chờ xác thực (status = processing)
4. Nhận callback và cập nhật trạng thái
5. Nếu thành công: cộng tiền vào tài khoản user
6. Lưu lịch sử giao dịch

**Lưu ý:**

- Tích hợp với nhà cung cấp dịch vụ nạp thẻ bên thứ 3
- Hỗ trợ nhiều nhà mạng
- Tính toán phí chiết khấu

#### 6.2. Nạp tiền qua chuyển khoản ngân hàng (Bank Deposit)

**Thông tin giao dịch:**

- Mã giao dịch (transaction_id) - khóa chính
- Số tài khoản ngân hàng nhận
- Số tiền chuyển (amount)
- Nội dung chuyển khoản (content)
- Ngân hàng: VPBank, TPBank, VietinBank, ACB, BIDV, MBBank, OCB, KienLongBank, MSB

**Tính năng tự động:**

- Lệnh Artisan tự động fetch giao dịch từ ngân hàng (FetchMBTransactions)
- Tự động đối chiếu nội dung chuyển khoản với mã user
- Tự động cộng tiền khi phát hiện giao dịch hợp lệ
- Ghi nhận transaction_id để tránh trùng lặp

**Quy trình:**

1. Admin thêm tài khoản ngân hàng nhận tiền
2. User xem thông tin chuyển khoản
3. User chuyển tiền với nội dung theo format
4. Cronjob tự động quét giao dịch ngân hàng
5. Hệ thống tự động cộng tiền khi tìm thấy giao dịch
6. Lưu lịch sử nạp tiền

#### 6.3. Quản lý tài khoản ngân hàng (Bank Accounts)

- Admin thêm, sửa, xóa thông tin tài khoản ngân hàng
- Hiển thị cho user khi nạp tiền
- Thông tin: ngân hàng, số tài khoản, chủ tài khoản, nội dung chuyển khoản

### 7. HỆ THỐNG RÚT TIỀN VÀ TÀI NGUYÊN

#### 7.1. Rút tiền mặt (Money Withdrawal)

**Thông tin yêu cầu rút:**

- Số tiền muốn rút
- Thông tin tài khoản ngân hàng người nhận
- Trạng thái: pending, success, error
- Ghi chú của user
- Ghi chú của admin (khi xử lý)

**Quy trình:**

1. User tạo yêu cầu rút tiền
2. Hệ thống kiểm tra số dư
3. Tạo đơn rút với status = pending
4. Admin xem danh sách yêu cầu chờ duyệt
5. Admin duyệt hoặc từ chối
6. Nếu duyệt: chuyển tiền thật và cập nhật status = success
7. Nếu từ chối: hoàn tiền và cập nhật status = error

#### 7.2. Rút vàng/ngọc (Resource Withdrawal)

**Thông tin yêu cầu rút:**

- Loại tài nguyên (type): gold (vàng) hoặc gem (ngọc)
- Số lượng muốn rút (amount)
- Tên nhân vật game nhận (character_name)
- Máy chủ (server)
- Ghi chú của user
- Ghi chú của admin
- Trạng thái: processing, success, error

**Quy trình:**

1. User chọn loại tài nguyên (vàng/ngọc)
2. Nhập số lượng, tên nhân vật, máy chủ
3. Hệ thống kiểm tra số dư
4. Tạo đơn rút với status = processing
5. Admin xem danh sách yêu cầu
6. Admin đăng nhập game và trade tài nguyên cho user
7. Admin cập nhật trạng thái thành công/thất bại

#### 7.3. Lịch sử rút tiền/tài nguyên

- User: Xem lịch sử rút tiền mặt
- User: Xem lịch sử rút vàng/ngọc
- User: Xem chi tiết từng yêu cầu rút
- Admin: Quản lý danh sách yêu cầu chờ xử lý
- Admin: Thống kê tổng số tiền/tài nguyên đã rút

### 8. HỆ THỐNG MÃ GIẢM GIÁ

#### 8.1. Quản lý mã giảm giá (Discount Codes)

**Thông tin mã giảm giá:**

- Mã code (unique)
- Loại giảm giá (discount_type):
  - percentage: Giảm theo phần trăm
  - fixed_amount: Giảm số tiền cố định
- Giá trị giảm (discount_value)
- Giá trị giảm tối đa (max_discount_value)
- Số tiền mua tối thiểu (min_purchase_amount)
- Trạng thái active/inactive
- Giới hạn số lần sử dụng (usage_limit)
- Số lần đã sử dụng (usage_count)
- Giới hạn mỗi user (per_user_limit)
- Đối tượng áp dụng (applicable_to):
  - account: Tài khoản game
  - random_account: Tài khoản random
  - service: Dịch vụ game
- Danh sách ID item áp dụng (item_ids) - JSON
- Ngày hết hạn (expire_date)
- Mô tả

**Chức năng:**

- Admin: Tạo, sửa, xóa mã giảm giá
- Admin: Xem thống kê sử dụng mã
- User: Nhập mã giảm giá khi mua hàng
- Hệ thống: Validate mã trước khi áp dụng
- Hệ thống: Tự động kiểm tra điều kiện áp dụng

#### 8.2. Lịch sử sử dụng mã giảm giá

- Lưu trữ chi tiết mỗi lần sử dụng (discount_code_usages)
- Thông tin: user, mã code, số tiền giảm, thời gian
- Admin xem lịch sử sử dụng từng mã
- Thống kê hiệu quả từng mã giảm giá

### 9. HỆ THỐNG GIAO DỊCH

#### 9.1. Lịch sử giao dịch (Money Transactions)

Hệ thống lưu trữ toàn bộ giao dịch tài chính:

**Các loại giao dịch (type):**

- deposit: Nạp tiền
- withdraw: Rút tiền
- purchase: Mua hàng (tài khoản/dịch vụ)
- refund: Hoàn tiền
- lucky_wheel: Chi phí vòng quay
- lucky_wheel_reward: Thưởng vòng quay

**Thông tin giao dịch:**

- User ID
- Loại giao dịch
- Số tiền
- Số dư trước giao dịch
- Số dư sau giao dịch
- Mô tả chi tiết
- Thời gian

**Chức năng:**

- User: Xem lịch sử giao dịch của mình
- Admin: Xem tất cả giao dịch trong hệ thống
- Thống kê doanh thu theo ngày/tháng
- Báo cáo tài chính

### 10. HỆ THỐNG THÔNG BÁO

#### 10.1. Thông báo hệ thống (Notifications)

**Loại thông báo:**

- Thông báo chung cho tất cả user
- Thông báo cá nhân cho từng user
- Thông báo sự kiện
- Thông báo bảo trì

**Thông tin thông báo:**

- Tiêu đề
- Nội dung (hỗ trợ HTML)
- Loại thông báo
- Trạng thái hiển thị
- Thời gian tạo

**Chức năng:**

- Admin: Tạo, sửa, xóa thông báo
- Admin: Đẩy thông báo đến người dùng
- User: Xem danh sách thông báo
- Hiển thị thông báo nổi bật trên trang chủ

#### 10.2. Email thông báo

- Reset password qua email
- Xác thực email đăng ký
- Thông báo giao dịch quan trọng
- Test email từ admin panel

### 11. TRANG QUẢN TRỊ (ADMIN PANEL)

#### 11.1. Dashboard

**Thống kê tổng quan:**

- Tổng số user (admin, user thường, mới trong ngày/tuần/tháng)
- Tổng số tài khoản game (có sẵn, đã bán, khóa, chờ xử lý)
- Tổng số tài khoản random (có sẵn, đã bán)
- Tổng số dịch vụ (active, inactive)
- Tổng số gói dịch vụ
- Tổng số danh mục (active, inactive)
- Tổng số danh mục random (active, inactive)
- Tổng số vòng quay (active, inactive)

**Thống kê tài chính:**

- Tổng tiền nạp vào hệ thống
- Tổng tiền rút ra
- Tổng tiền từ mua hàng
- Tổng tiền hoàn trả
- Biểu đồ doanh thu 7 ngày gần nhất

**Đơn hàng chờ xử lý:**

- Danh sách 5 đơn dịch vụ chờ xử lý
- Danh sách 5 yêu cầu rút tiền chờ duyệt
- Thông tin user và thời gian tạo

#### 11.2. Quản lý người dùng

- Xem danh sách tất cả user
- Tìm kiếm user theo username, email
- Chỉnh sửa thông tin user
- Cập nhật số dư tài khoản
- Thay đổi role (admin/user)
- Khóa/mở khóa tài khoản (banned)
- Xóa tài khoản user

#### 11.3. Quản lý nội dung

**Quản lý danh mục:**

- CRUD danh mục tài khoản game
- CRUD danh mục random
- Upload ảnh thumbnail
- Quản lý slug SEO

**Quản lý tài khoản:**

- CRUD tài khoản game
- CRUD tài khoản random
- Upload nhiều ảnh
- Quản lý trạng thái

**Quản lý dịch vụ:**

- CRUD dịch vụ game
- CRUD gói dịch vụ
- Quản lý loại dịch vụ
- Upload ảnh

**Quản lý vòng quay:**

- CRUD vòng quay may mắn
- Cấu hình 8 phần thưởng
- Upload ảnh vòng quay
- Quản lý giá và thể lệ

**Quản lý mã giảm giá:**

- CRUD mã giảm giá
- Cấu hình điều kiện áp dụng
- Theo dõi số lần sử dụng

#### 11.4. Quản lý đơn hàng

**Đơn hàng dịch vụ:**

- Xem danh sách đơn hàng dịch vụ
- Lọc theo trạng thái
- Duyệt đơn hàng
- Từ chối đơn hàng
- Thêm ghi chú xử lý

**Yêu cầu rút tiền:**

- Xem danh sách yêu cầu rút tiền mặt
- Xem danh sách yêu cầu rút vàng/ngọc
- Duyệt yêu cầu
- Từ chối yêu cầu
- Thêm ghi chú

#### 11.5. Lịch sử và báo cáo

**Các loại lịch sử:**

- Lịch sử giao dịch tài chính
- Lịch sử mua tài khoản game
- Lịch sử mua tài khoản random
- Lịch sử đặt dịch vụ
- Lịch sử nạp tiền qua ngân hàng
- Lịch sử nạp tiền qua thẻ cào
- Lịch sử sử dụng mã giảm giá
- Lịch sử vòng quay may mắn
- Lịch sử rút tiền/tài nguyên

**Tính năng:**

- Phân trang
- Tìm kiếm
- Lọc theo thời gian
- Export dữ liệu

#### 11.6. Cài đặt hệ thống

**Cài đặt chung (General):**

- Tên website
- Logo
- Favicon
- Mô tả website
- Keywords SEO
- Thông tin liên hệ

**Cài đặt mạng xã hội (Social):**

- Facebook App ID, App Secret
- Google Client ID, Client Secret
- Bật/tắt đăng nhập mạng xã hội

**Cài đặt email (Email):**

- SMTP Host
- SMTP Port
- SMTP Username
- SMTP Password
- Email gửi đi
- Tên người gửi
- Test gửi email

**Cài đặt thanh toán (Payment):**

- Cấu hình API nạp thẻ cào
- Cấu hình API ngân hàng
- Tỷ lệ chiết khấu nạp thẻ
- Phí rút tiền

**Cài đặt đăng nhập (Login):**

- Bật/tắt đăng ký
- Bật/tắt đăng nhập Google
- Bật/tắt đăng nhập Facebook
- Yêu cầu xác thực email

**Quản lý thông báo:**

- Tạo thông báo mới
- Chỉnh sửa thông báo
- Xóa thông báo
- Quản lý hiển thị

### 12. TÍNH NĂNG BẢO MẬT

#### 12.1. Xác thực và Phân quyền

- Middleware Authenticate kiểm tra đăng nhập
- Middleware AdminMiddleware kiểm tra quyền admin
- CSRF Protection cho tất cả form
- Password hashing với Bcrypt
- Session timeout tự động

#### 12.2. Bảo vệ dữ liệu

- SQL Injection protection (Eloquent ORM)
- XSS Protection
- Validation input chặt chẽ
- Sanitize user input
- Rate limiting cho API

#### 12.3. Quản lý tài khoản

- Theo dõi IP đăng nhập
- Khóa tài khoản vi phạm
- Đặt lại mật khẩu an toàn
- Xác thực email

### 13. TÍNH NĂNG NÂNG CAO

#### 13.1. SEO-Friendly

- URL slug cho tất cả danh mục và dịch vụ
- Meta tags động
- Sitemap tự động
- Robot.txt

#### 13.2. Tối ưu hiệu suất

- Query optimization với Eloquent
- Eager loading để tránh N+1 problem
- Cache config với Laravel Cache
- Asset compilation với Vite

#### 13.3. Artisan Commands

**ClearAllCaches:**

- Xóa tất cả cache
- Xóa config cache
- Xóa route cache
- Xóa view cache

**FetchMBTransactions:**

- Tự động quét giao dịch ngân hàng
- Tự động cộng tiền cho user
- Chạy định kỳ bằng Cron Job

#### 13.4. Helper Functions

**ConfigHelper:**

- Lấy cấu hình hệ thống
- Cache config để tăng tốc
- Facade để gọi dễ dàng

**UploadHelper:**

- Upload file với validation
- Resize ảnh tự động
- Lưu trữ có tổ chức
- Xóa file cũ khi cập nhật

### 14. GIAO DIỆN NGƯỜI DÙNG

#### 14.1. Trang chủ

- Hiển thị banner/slider
- Danh sách danh mục nổi bật
- Tài khoản mới nhất
- Dịch vụ game
- Vòng quay may mắn
- Thông báo hệ thống

#### 14.2. Trang danh mục

- Lọc tài khoản theo giá
- Lọc theo máy chủ
- Lọc theo hành tinh
- Tìm kiếm tài khoản
- Phân trang

#### 14.3. Trang chi tiết tài khoản

- Thông tin đầy đủ
- Gallery ảnh
- Nút mua hàng
- Áp dụng mã giảm giá
- Thông tin bảo mật

#### 14.4. Responsive Design

- Tương thích mobile, tablet, desktop
- Menu mobile
- Touch-friendly
- Fast loading

### 15. CÔNG CỤ PHÁT TRIỂN

#### 15.1. Testing

- PHPUnit cho unit testing
- Feature tests
- Browser tests

#### 15.2. Code Quality

- Laravel Pint cho code formatting
- PSR-12 coding standard
- Blade components tái sử dụng

#### 15.3. Version Control

- Git repository
- Branches: main, develop
- Commit message standards

## CÀI ĐẶT VÀ TRIỂN KHAI

### Yêu cầu hệ thống

- PHP >= 8.1
- MySQL >= 5.7 hoặc MariaDB >= 10.3
- Composer
- Node.js và NPM
- Apache/Nginx
- SSL Certificate (khuyến nghị)

### Hướng dẫn cài đặt

1. Clone repository hoặc tải source code
2. Chạy `composer install` để cài đặt dependencies
3. Chạy `npm install && npm run build` để build assets
4. Copy `.env.example` thành `.env` và cấu hình database
5. Chạy `php artisan key:generate` để tạo application key
6. Chạy `php artisan migrate` để tạo database
7. Chạy `php artisan storage:link` để link storage
8. Cấu hình web server (Apache/Nginx) trỏ đến thư mục `public`
9. Cấu hình cron job cho `php artisan schedule:run`

### Cấu hình môi trường

Chi tiết cấu hình trong file `.env`:

- Database connection
- SMTP email settings
- Social login credentials
- Payment gateway API keys
- Application URL

## BẢO TRÌ VÀ HỖ TRỢ

### Backup

- Backup database định kỳ
- Backup files upload
- Backup cấu hình

### Monitoring

- Theo dõi error logs trong `storage/logs`
- Monitoring database performance
- Tracking user activities

### Update

- Cập nhật Laravel framework
- Cập nhật packages thường xuyên
- Kiểm tra security patches
