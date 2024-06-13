import Logout from '@/assets/icons/Logout';
import PlayList from '@/assets/icons/PlayList';
import Profile from '@/assets/icons/Profile';
import Radio from '@/assets/icons/Radio';
import Video from '@/assets/icons/Video';
import { Home } from '@mui/icons-material';
import { Avatar, Box, IconButton, Stack } from '@mui/material';
import React from 'react';
import Link from 'next/link';
import router from 'next/router';
import { BASE_URL, logout } from '@/lib/utils';
import { useUserQuery } from '@/hooks';

// Thành phần SideBar
export const SideBar = () => {
  // Sử dụng hook để lấy dữ liệu người dùng
  const { data: user } = useUserQuery();

  return (
    <Box
      display="flex"
      flexDirection="column"
      position="fixed"
      top="90px"
      left="25px"
      zIndex={999}
    >
      {/* Ngăn xếp các nút chức năng */}
      <Stack
        bgcolor="#1A1E1F"
        borderRadius="32px"
        py="25px"
        px="15px"
        spacing="20px"
        mb="20px"
      >
        {/* Nút trang chủ */}
        <IconButton LinkComponent={Link} href="/" sx={{ color: 'white' }}>
          <Home />
        </IconButton>
        {/* Nút danh sách phát */}
        <IconButton>
          <PlayList />
        </IconButton>
        {/* Nút radio */}
        <IconButton>
          <Radio />
        </IconButton>
        {/* Nút video */}
        <IconButton>
          <Video />
        </IconButton>
      </Stack>
      {/* Ngăn xếp thông tin người dùng */}
      <Stack
        bgcolor="#1A1E1F"
        borderRadius="32px"
        py="25px"
        px="15px"
        spacing="20px"
        alignItems="center"
      >
        {/* Hiển thị avatar người dùng nếu đã đăng nhập */}
        {user ? (
          <Avatar
            alt="Remy Sharp"
            src={`${BASE_URL}${user.avatar}`}
            sx={{ width: 30, height: 30 }}
          />
        ) : (
          // Nút đăng nhập nếu chưa đăng nhập
          <IconButton LinkComponent={Link} href="/login">
            <Profile />
          </IconButton>
        )}

        {/* Nút đăng xuất nếu người dùng đã đăng nhập */}
        {user && (
          <IconButton
            onClick={() => {
              void logout().then((_res) => {
                document.cookie =
                  'access_token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
                void router.push('/login');
              });
            }}
          >
            <Logout />
          </IconButton>
        )}
      </Stack>
    </Box>
  );
};

