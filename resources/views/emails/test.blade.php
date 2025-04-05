<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Kiểm tra cấu hình email</title>
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

        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #777;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            @if (config_get('site_logo'))
                <img src="{{ config_get('site_logo') }}" alt="{{ config_get('site_name') }}" class="logo">
            @endif
            <h2>Kiểm tra cấu hình email</h2>
        </div>
        <div class="content">
            <p>Xin chào!</p>
            <p>Email này được gửi từ <strong>{{ config_get('site_name') }}</strong> để kiểm tra cấu hình email của hệ
                thống.</p>
            <p>Nếu bạn nhận được email này, điều đó có nghĩa rằng cấu hình email của hệ thống đã được thiết lập chính
                xác.</p>
            <p>Thời gian gửi: {{ now()->format('H:i:s d/m/Y') }}</p>
            <p>Cảm ơn bạn!</p>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} {{ config_get('site_name') }}. Tất cả quyền được bảo lưu.</p>
            <p>{{ config_get('address') }} | {{ config_get('phone') }} | {{ config_get('email') }}</p>
        </div>
    </div>
</body>

</html>
