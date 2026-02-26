@extends('layouts.app')

@section('title', 'Contact Us - HappyPet Store')

@section('content')
<div class="contact-hero">
    <div class="contact-hero-content">
        <h1 class="contact-hero-title">Hubungi Kami</h1>
        <p class="contact-hero-subtitle">Kami siap membantu Anda dengan pertanyaan atau kebutuhan apapun</p>
    </div>
    <div class="contact-hero-pattern"></div>
</div>

<div class="contact-container">
    <div class="contact-info-cards">
        <div class="info-card" style="animation-delay: 0.1s">
            <div class="info-icon">📞</div>
            <h3>Telepon</h3>
            <p>+62 274 123 4567</p>
            <p class="info-subtitle">Senin - Jumat, 09:00 - 17:00</p>
        </div>
        <div class="info-card" style="animation-delay: 0.2s">
            <div class="info-icon">✉️</div>
            <h3>Email</h3>
            <p>info@happypet.com</p>
            <p class="info-subtitle">Respon dalam 24 jam</p>
        </div>
        <div class="info-card" style="animation-delay: 0.3s">
            <div class="info-icon">📍</div>
            <h3>Lokasi</h3>
            <p>Jl. Pet Lover No. 123</p>
            <p class="info-subtitle">Bandung, Jawa Barat</p>
        </div>
    </div>

    <div class="contact-wrapper">
        <div class="contact-form-section">
            <h2 class="section-title">Kirim Pesan Kepada Kami</h2>
            <form action="#" class="contact-form">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" placeholder="Masukkan nama Anda..." required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" placeholder="email@contoh.com" required>
                </div>
                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <input type="tel" placeholder="+62 8xx xxxx xxxx" required>
                </div>
                <div class="form-group">
                    <label>Subjek</label>
                    <input type="text" placeholder="Topik pertanyaan Anda..." required>
                </div>
                <div class="form-group">
                    <label>Pesan</label>
                    <textarea rows="6" placeholder="Apa yang bisa kami bantu?"></textarea>
                </div>
                <button type="submit" class="btn-send">Kirim Pesan</button>
            </form>
        </div>

        <div class="contact-map-section">
            <h2 class="section-title">Kunjungi Toko Kami</h2>
            <div class="map-container">
                <div class="map-responsive">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126748.56347862248!2d107.5731164058055!3d-6.903444341688533!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e6398252477f%3A0x146a941033067e40!2sBandung%2C%20Kota%20Bandung%2C%20Jawa%20Barat!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" 
                        width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            </div>
            <div class="store-hours">
                <h3>Jam Operasional</h3>
                <ul>
                    <li><span>Senin - Jumat:</span> 09:00 - 17:00</li>
                    <li><span>Sabtu:</span> 10:00 - 16:00</li>
                    <li><span>Minggu:</span> Tutup</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
