import { BASE_URL } from '@/lib/utils';
import axios from 'axios';
import Cookies from 'js-cookie';
import router from 'next/router';

export default function Sigout() {
  // Lấy token từ cookie
  const ACCESS_TOKEN = Cookies.get('access_token') as string;

  const logout = async () => {
    try {
      // Gửi yêu cầu đăng xuất tới server
      void axios
        .post(
          `${BASE_URL}api/auth/logout`,
          {},
          {
            headers: {
              'Content-Type': 'application/json',
              Accept: 'application/json',
              Authorization: `Bearer ${ACCESS_TOKEN}`,
            },
          }
        )
        .then(() => {
          // Xử lý sau khi nhận được phản hồi từ server (nếu cần)
        });
    } catch (err) {
      // In ra lỗi nếu có lỗi xảy ra
      console.log(err);
    }

    // Xóa token khỏi cookie
    document.cookie =
      'access_token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
    // Chuyển hướng người dùng tới trang đăng nhập
    void router.push('/login');
  };

  // Gọi hàm đăng xuất khi component được render
  void logout();
}
