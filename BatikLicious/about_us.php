<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BatikLicious</title>
    <link rel="Stylesheet" href="styles.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body>
    <nav>
        <div class="logo">
            <img src="images/navLogo.svg">
        </div>

        <ul>
            <li><a href="homepage.php">Home</a></li>
            <li><a href="collections.php">Collection</a></li>
            <li><a href="about_us.php">About Us</a></li>
            <?php
            session_start();
            if (isset($_SESSION['loggedin'])) {
                // apabila user telah login, makan tombol account akan berubah ke Profile
                echo '<div class="accCart">
                            <li><img src="images/account_icon.png" style="height: 25px;"><a href="phplogin/profile.php">Profile</a></li>
                            <li><img src="images/cart_icon.png" style="height: 25px;"><a href="cart.php">Cart</a></li>
                        </div>';
            } else {
                // jika belum login, tampilkan login link
                echo '<div class="accCart">
                            <li><img src="images/account_icon.png" style="height: 25px;"><a href="phplogin/index.html">Login</a></li>
                            <li><img src="images/cart_icon.png" style="height: 25px;"><a href="cart.php">Cart</a></li>
                        </div>';
            }
            ?>
        </ul>

        <div class="menu-toggle">
            <input type="checkbox" name="" id="" />
              <span></span>
              <span></span>
              <span></span>
    </nav>

<section class="AboutUs">
    <div class="container">
        <img src="images/about us1.jpg">
        <div class="text-overlay">
            <h3>Warnai Tradisi, Kenyamanan Modern, Batik Untuk Semua</h3>
            
        </div>
    </div>
    <div class="persegi-panjang">
    <div class="about">  
        <img src="images/about us2.JPG">
        <img src="images/about us3.JPG">
    <div class="Batik Licious">
        <h3>WHO IS BATIK LICIOUS?</h3>
        <p>Batik Licious adalah sebuah situs website yang menyediakan tempat untuk pembelian batik secara online. Dengan memberikan deskripsi batik secara rinci mulai dari corak, motif, pola hingga bahan yang digunakan dengan harga terjangkau dan kualitas terbaik. Batik yang disediakan memiliki desain batik modern dengan mengutamakan kenyamanan bagi para penggunanya. Karena desain yang modern memungkinkan semua kalangan cocok untuk memakai batik ini. Website ini mulai dibuka pada tanggal 23 Februari 2024 dengan lima orang sebagai adminnya. Kami bergerak untuk mendukung UMKM batik Indonesia.</p>

    </section>

    <section class="VisionMission">
    <div class="container">
        <div class="image">
            <img src="images/batiklicious.JPG">
        </div>
        <div class="text">
            <div class="vision">
                <h3>Visi</h3>
                <p>Menjadi platform terkemuka yang menginspirasi dan  mengedepankan keindahan dan warisan budaya Indonesia serta dapat menjadi media promosi warisan budaya batik Indonesia diseluruh dunia.</p>
            </div>
            <div class="mission">
                <h3>Misi</h3>
                <ul>
                    <li>Meningkatkan kesadaran dan apresiasi terhadap seni dan budaya batik melalui koleksi yang unik dan berkualitas.</li>
                    <li>Menyediakan produk batik yang berkualitas tinggi dan otentik, dengan memastikan setiap produk dibuat dengan teknik tradisional yang akurat.</li>
                    <li>Memberikan pengalaman belanja online yang mudah, aman, dan menyenangkan bagi pelanggan melalui pelayanan yang ramah dan profesional.</li>
                    <li>Berkontribusi dalam pelestarian budaya batik dengan mengadakan berbagai program edukasi dan workshop tentang batik bagi masyarakat umum.</li>
                    <li>Menggabungkan desain tradisional dengan sentuhan modern untuk memenuhi kebutuhan dan selera pasar yang beragam.</li>
                </ul>
            </div>
        </div>
    </div>
</section>

    <footer>
        <div class="footer-content">
            <div class="footer-logo">
                <img src="images/batikliciousLogoFooter.svg" alt="">
            </div>
            <div class="footer-section">
                <h3>About Us</h3>
                <p>Batik Licious adalah sebuah situs website yang menyediakan tempat untuk pembelian batik secara
                    online. Dengan memberikan deskripsi batik secara rinci mulai dari corak, motif, pola hingga
                    bahan yang digunakan dengan harga terjangkau dan kualitas terbaik. </p>
            </div>
            <div class="footer-section">
                <h3>Contact Us</h3>
                <p>Email: BatikLicious9@gmail.com</p>
                <p>Phone: 082271299958</p>
            </div>
            <div class="footer-section">
                <h3>Follow Us</h3>
                <div class="social-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path fill="currentColor" fill-rule="evenodd"
                            d="M3 8a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v8a5 5 0 0 1-5 5H8a5 5 0 0 1-5-5V8Zm5-3a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3H8Zm7.597 2.214a1 1 0 0 1 1-1h.01a1 1 0 1 1 0 2h-.01a1 1 0 0 1-1-1ZM12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm-5 3a5 5 0 1 1 10 0 5 5 0 0 1-10 0Z"
                            clip-rule="evenodd" />
                    </svg>
                    <a href="#" class="social-link">BatikLicious</a>
                </div>
                <div class="social-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M13.135 6H15V3h-1.865a4.147 4.147 0 0 0-4.142 4.142V9H7v3h2v9.938h3V12h2.021l.592-3H12V6.591A.6.6 0 0 1 12.592 6h.543Z"
                            clip-rule="evenodd" />
                    </svg>
                    <a href="#" class="social-link">BatikLicious</a>
                </div>
                <div class="social-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M22 5.892a8.178 8.178 0 0 1-2.355.635 4.074 4.074 0 0 0 1.8-2.235 8.343 8.343 0 0 1-2.605.981A4.13 4.13 0 0 0 15.85 4a4.068 4.068 0 0 0-4.1 4.038c0 .31.035.618.105.919A11.705 11.705 0 0 1 3.4 4.734a4.006 4.006 0 0 0 1.268 5.392 4.165 4.165 0 0 1-1.859-.5v.05A4.057 4.057 0 0 0 6.1 13.635a4.192 4.192 0 0 1-1.856.07 4.108 4.108 0 0 0 3.831 2.807A8.36 8.36 0 0 1 2 18.184 11.732 11.732 0 0 0 8.291 20 11.502 11.502 0 0 0 19.964 8.5c0-.177 0-.349-.012-.523A8.143 8.143 0 0 0 22 5.892Z"
                            clip-rule="evenodd" />
                    </svg>
                    <a href="#" class="social-link">BatikLiciousAja</a>
                </div>
            </div>
        </div>
    </footer>
    <script src="script.js"></script>
</body>

</html>