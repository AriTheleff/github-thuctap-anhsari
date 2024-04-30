@extends('home.home')

@section('content')
<main id="main">
    <section id="contact" class="contact mb-5">
        <div class="container" data-aos="fade-up">

            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h1 class="page-title">Chỉnh sửa thông tin cá nhân</h1>
                </div>
            </div>

            <div class="form mt-5">
                <form id="editProfileForm" class="php-email-form" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <input type="text" name="username" class="form-control" value="{{$user->username}}" placeholder="Nhập tên người dùng">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="email" name="email" class="form-control" value="{{$user->email}}" placeholder="Nhập địa chỉ email">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu mới">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Xác nhận mật khẩu">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="imageInput">Chọn ảnh đại diện mới:</label>
                            <input type="file" id="imageInput" name="image" class="form-control" accept="image/*" onchange="previewImage(this)">
                            <div class="text-center mt-2">
                                @if($user->avatar)
                                <img id="imagePreview" src="{{ asset('/storage/' . $user->avatar) }}" alt="Current Image" width="300">
                                @else
                                <p class="text-muted">Bạn chưa có ảnh đại diện</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="text-center"><button type="submit" id="updateProfileBtn">Lưu thay đổi</button></div>
                </form>
            </div><!-- End Contact Form -->

        </div>
    </section>
</main><!-- End #main -->

<!-- ======= Footer ======= -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Submit form using AJAX
        $('#editProfileForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('profile.update') }}",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: response.success
                    }).then(function() {
                        var previousPage = document.referrer; // Lấy đường dẫn của trang trước đó
                        window.location.href = previousPage; // Chuyển hướng về trang trước đó sau khi đóng thông báo
                    });
                },
                error: function(xhr, status, error) {
                    // Show error message using SweetAlert
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON.message
                    });
                }
            });
        });
    });


    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection