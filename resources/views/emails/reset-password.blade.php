<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Đặt lại mật khẩu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #0E3EDA;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 5px 5px 0 0;
            margin-bottom: 20px;
        }

        .logo {
            max-width: 150px;
            height: auto;
            margin-bottom: 10px;
        }

        .content {
            padding: 20px;
            background-color: white;
            border-radius: 5px;
        }

        .btn-reset {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            background-color: #0E3EDA;
            color: white !important;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #777;
            font-size: 12px;
        }

        .expiration {
            font-size: 13px;
            color: #666;
            margin-top: 20px;
            padding: 10px;
            background-color: #f5f5f5;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            @if (config_get('site_logo'))
                <img src="{{ config_get('site_logo') }}" alt="{{ config_get('site_name') }}" class="logo">
            @endif
            <h2>Đặt lại mật khẩu</h2>
        </div>
        <div class="content">
            <p>Xin chào {{ $notifiable->username ?? 'Quý khách' }}!</p>
            <p>Bạn nhận được email này vì chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn trên
                <strong>{{ config_get('site_name') }}</strong>.
            </p>
            <p>Vui lòng nhấp vào nút bên dưới để đặt lại mật khẩu của bạn:</p>

            <div style="text-align: center;">
                <a href="{{ $resetUrl }}" class="btn-reset">Đặt lại mật khẩu</a>
            </div>

            <div class="expiration">
                <p>Liên kết đặt lại mật khẩu này sẽ hết hạn sau 60 phút.</p>
                <p>Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này và không cần thực hiện thêm hành
                    động nào.</p>
            </div>

            <p>Nếu bạn gặp sự cố khi nhấp vào nút "Đặt lại mật khẩu", hãy sao chép và dán URL này vào trình duyệt web
                của bạn: <br>
                <a href="{{ $resetUrl }}">{{ $resetUrl }}</a>
            </p>

            <p>Trân trọng,<br>{{ config_get('site_name') }}</p>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} {{ config_get('site_name') }}. Tất cả quyền được bảo lưu.</p>
            <p>{{ config_get('address') }} | {{ config_get('phone') }} | {{ config_get('email') }}</p>
        </div>
    </div>
</body>

</html>
