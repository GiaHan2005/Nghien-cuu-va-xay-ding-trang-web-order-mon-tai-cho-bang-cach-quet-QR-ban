<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE-edge'>
    <title>Giới thiệu quán</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 100px;
            color: #333;
            line-height: 1.6;
            background-image: url('anhgioithieu.png'); 
            background-size: cover; 
            background-position: center center; 
            background-attachment: fixed; 
            background-repeat: no-repeat;
            position: relative; 
            z-index: 1; 
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.6); 
            z-index: -1; 
        }

        .container {
            position: relative; 
            z-index: 2; 
        }

        h1 {
            color: #d9534f; 
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 15px;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
            padding: 10px 20px; 
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 8px; 
            display: inline-block;
            margin: 50px auto;
        }
        
        .intro {
            text-align: justify;   
            font-style: italic;  
            font-size: 1.1em;
            color: #222; 
            font-weight: 500; 
            margin-bottom: 30px;
            background-color: rgba(255, 255, 255, 0.8); 
            padding: 20px 30px; 
            border-radius: 8px; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.08); 
        }
        .intro:hover {
            transform: scale(1.03); 
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        }
        .contact-info {
            background: rgba(255, 255, 255, 0.85); 
            border-left: 5px solid #d9534f; 
            padding: 20px 30px; 
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
            margin-top: 30px; 
            margin-bottom: 30px; 
            transition: transform 0.3s ease, box-shadow 0.3s ease;
}
        .contact-info:hover {
            transform: scale(1.03); 
            box-shadow: 0 8px 16px rgba(0,0,0,0.15); 
}
        .closing {
            text-align: center;
            font-size: 1.2em;
            font-weight: bold;
            color: #333; 
            margin-top: 30px;
            text-shadow: 1px 1px 3px rgba(255,255,255,0.5); 
            background-color: rgba(255, 255, 255, 0.7); /* Nền trắng mờ cho lời kết */
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .closing:hover {
            transform: scale(1.03); 
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        }
    </style>

    </style>
</head>
<body>
    
    <div class="container">
        <h1>Chào mừng đến với tiệm trà nè!</h1>

        <p class="intro">
            Nơi đây không chỉ là một quán trà sữa, mà là điểm hẹn lý tưởng cho những tâm hồn đồng điệu. 
            Chúng tôi tự hào mang đến những ly đồ uống chất lượng nhất, từ trà trái cây thanh mát, trà sữa béo ngậy 
            đến những ly cà phê đậm đà, cùng các món ăn vặt "mồi bén" không thể chối từ. 
        </p>

        <div class="contact-info">
            <h2>Thông tin liên hệ</h2>
            
            <p>
                <span class="icon">📞</span>
                <strong>Hotline:</strong> 0123 456 789
            </p>
            
            <p>
                <span class="icon">📍</span>
                <strong>Địa chỉ:</strong> 123 Đường ABC, Phường XYZ, Quận 1, TP. Hồ Chí Minh
            </p>

            <p>
                <span class="icon">⏰</span>
                <strong>Giờ mở cửa:</strong> 8:00 Sáng - 10:00 Tối (Tất cả các ngày)
            </p>
        </div>

        <p class="closing">
            Hãy ghé qua để thư giãn và tận hưởng. Chúng tôi luôn sẵn sàng phục vụ!
        </p>

    </div>

</body>
</html>