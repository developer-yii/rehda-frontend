<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
  <div class="card">
  <div class="container-xxl pt-3">
    <!-- Logo and Main Info -->
    <div class="text-center mb-2">
      <img src="{{asset('frontend/img/logo/email-rehda-logo-blue.png')}}" alt="REHDA Logo" height="60" class="mb-2">
      <h6 class="fw-bolder mb-1">Real Estate Housing Developers' Association (REHDA) Malaysia</h6>
      <p class="text-muted mb-1">(ROS No.: PPM-002-10-21051970)</p>
    </div>

    <!-- Address -->
    <div class="text-center mb-2">
      <p class="mb-0">Wisma REHDA</p>
      <p class="mb-0">No. 2C, Jalan SS5D/6, Kelana Jaya</p>
      <p class="mb-1">47301 Petaling Jaya, Selangor Darul Ehsan</p>
    </div>

    <!-- Contact Info -->
    <div class="d-flex justify-content-center flex-wrap gap-4 mb-3">
      <div class="d-flex align-items-center">
        <i class="ti ti-phone me-1"></i>
        {{-- <span>Tel: 03-7803 2978</span> --}}
        <span>Tel: <a href="tel:03-7803 5285" style="color: inherit" target="_blank">03-7803 2978</a></span>
      </div>
      <div class="d-flex align-items-center">
        <i class="ti ti-printer me-1"></i>
        <span>Fax: <a href="tel:03-7803 5285" style="color: inherit" target="_blank">03-7803 5285</a></span>
      </div>
      <div class="d-flex align-items-center">
        <i class="ti ti-mail me-1"></i>
        <span>Email: <a href="mailto:secretariat@rehda.com" style="color: inherit">secretariat@rehda.com</a></span>
      </div>
      <div class="d-flex align-items-center">
        <i class="ti ti-world me-1"></i>
        <span>Website: <a href="https://rehda.com" style="color: inherit" target="_blank">https://rehda.com</a></span>
      </div>
    </div>

    <!-- Links -->
    <div class="d-flex justify-content-center flex-wrap gap-3 mb-3">
      <a href="{{ route('termsAndConditions')}}" class="text-primary" target="_blank">Term and Conditions</a>
      <span class="text-muted">|</span>
      <a href="{{ route('membership')}}" class="text-primary" target="_blank">Membership</a>
      <span class="text-muted">|</span>
      <a href="{{ route('termsAndConditions')}}#privacy-policy" class="text-primary" target="_blank">Privacy Policy</a>
      <span class="text-muted">|</span>
      <a href="{{ route('termsAndConditions')}}#refund-policy" class="text-primary" target="_blank">Refund Policy</a>
    </div>

    <!-- Copyright -->
    <div class="text-center text-muted mb-2">
      <small>2022 Copyright © REHDA Malaysia (ROS No.: PPM-002-10-21051970). All Rights Reserved</small>
    </div>
  </div>
</div>
</footer>
<!-- / Footer -->