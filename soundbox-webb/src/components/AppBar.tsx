import { useState } from 'react';

import Link from 'next/link';
import router from 'next/router';

// Import các công cụ styled và alpha từ @mui/material/styles
import { styled, alpha } from '@mui/material/styles';
// Import các thành phần cần thiết từ Material UI
import {
  Box,
  Toolbar,
  IconButton,
  InputBase,
  Badge,
  MenuItem,
  Menu,
} from '@mui/material';
// Import các biểu tượng từ Material UI
import {
  Notifications,
  Search as SearchIcon,
  AccountCircle,
  Mail,
} from '@mui/icons-material';

// Import thành phần ThemeUpdater
import ThemeUpdater from './ThemeUpdater';
// Import logo từ thư mục assets
import Logo from '@/assets/icons/Logo';

// Tạo thành phần Search được styled
const Search = styled('div')(({ theme }) => ({
  position: 'relative',
  borderRadius: '32px',
  '&:hover': {
    backgroundColor: alpha(theme.palette.common.white, 0.25),
  },
  marginRight: theme.spacing(2),
  marginLeft: 0,
  width: '100%',
  [theme.breakpoints.up('sm')]: {
    marginLeft: theme.spacing(3),
    width: 'auto',
  },
  transition: 'background-color 0.3s',
}));

// Tạo thành phần SearchIconWrapper được styled
const SearchIconWrapper = styled('div')(({ theme }) => ({
  padding: theme.spacing(0, 2),
  height: '100%',
  position: 'absolute',
  pointerEvents: 'none',
  display: 'flex',
  alignItems: 'center',
  justifyContent: 'center',
}));

// Tạo thành phần StyledInputBase được styled
const StyledInputBase = styled(InputBase)(({ theme }) => ({
  color: 'inherit',
  '& .MuiInputBase-input': {
    padding: theme.spacing(1, 1, 1, 0),
    paddingLeft: `calc(1em + ${theme.spacing(4)})`,
    transition: theme.transitions.create('width'),
    width: '100%',
    [theme.breakpoints.up('md')]: {
      width: '20ch',
    },
  },
}));

// Thành phần chính PrimarySearchAppBar
export const PrimarySearchAppBar = () => {
  // Trạng thái cho giá trị nhập vào ô tìm kiếm
  const [inputValue, setInputValue] = useState('');

  // Xử lý sự kiện khi nhấn phím Enter trong ô tìm kiếm
  const handleKeyPress = (event: React.KeyboardEvent<HTMLInputElement>) => {
    if (event.key === 'Enter') {
      // Gọi hàm xử lý tại đây
      console.log('Enter đã được nhấn');
      void router.push(`/search/${inputValue}`);
    }
  };

  // Xử lý sự kiện khi thay đổi giá trị ô tìm kiếm
  const handleChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    setInputValue(event.target.value);
  };

  // Trạng thái và các hàm xử lý menu
  const [anchorEl, setAnchorEl] = useState<null | HTMLElement>(null);
  const [mobileMoreAnchorEl, setMobileMoreAnchorEl] =
    useState<null | HTMLElement>(null);

  const isMenuOpen = Boolean(anchorEl);
  const isMobileMenuOpen = Boolean(mobileMoreAnchorEl);

  const handleProfileMenuOpen = (event: React.MouseEvent<HTMLElement>) => {
    setAnchorEl(event.currentTarget);
  };

  const handleMobileMenuClose = () => {
    setMobileMoreAnchorEl(null);
  };

  const handleMenuClose = () => {
    setAnchorEl(null);
    handleMobileMenuClose();
  };

  // ID của menu chính và menu trên thiết bị di động
  const menuId = 'primary-search-account-menu';
  const renderMenu = (
    <Menu
      anchorEl={anchorEl}
      anchorOrigin={{
        vertical: 'top',
        horizontal: 'right',
      }}
      id={menuId}
      keepMounted
      transformOrigin={{
        vertical: 'top',
        horizontal: 'right',
      }}
      open={isMenuOpen}
      onClose={handleMenuClose}
    >
      <MenuItem onClick={handleMenuClose}>Profile</MenuItem>
      <MenuItem onClick={handleMenuClose}>My account</MenuItem>
    </Menu>
  );

  const mobileMenuId = 'primary-search-account-menu-mobile';
  const renderMobileMenu = (
    <Menu
      anchorEl={mobileMoreAnchorEl}
      anchorOrigin={{
        vertical: 'top',
        horizontal: 'right',
      }}
      id={mobileMenuId}
      keepMounted
      transformOrigin={{
        vertical: 'top',
        horizontal: 'right',
      }}
      open={isMobileMenuOpen}
      onClose={handleMobileMenuClose}
    >
      <MenuItem>
        <IconButton size="large" aria-label="show 4 new mails" color="inherit">
          <Badge badgeContent={4} color="error">
            <Mail />
          </Badge>
        </IconButton>
        <p>Messages</p>
      </MenuItem>
      <MenuItem>
        <IconButton
          size="large"
          aria-label="show 17 new notifications"
          color="inherit"
        >
          <Badge badgeContent={17} color="error">
            <Notifications />
          </Badge>
        </IconButton>
        <p>Notifications</p>
      </MenuItem>
      <MenuItem onClick={handleProfileMenuOpen}>
        <IconButton
          size="large"
          aria-label="account of current user"
          aria-controls="primary-search-account-menu"
          aria-haspopup="true"
          color="inherit"
        >
          <AccountCircle />
        </IconButton>
        <p>Profile</p>
      </MenuItem>
      <MenuItem>
        <ThemeUpdater />
      </MenuItem>
    </Menu>
  );

  // Giao diện của PrimarySearchAppBar
  return (
    <>
      <Box position="fixed" top="0" left="0" right="0" zIndex={9999}>
        <Toolbar sx={{ bgcolor: 'transparent' }}>
          <IconButton
            size="large"
            edge="start"
            color="inherit"
            aria-label="open drawer"
            sx={{ mr: 2 }}
            LinkComponent={Link}
            href="/"
          >
            <Logo />
          </IconButton>
          <Search>
            <SearchIconWrapper>
              <SearchIcon />
            </SearchIconWrapper>
            <StyledInputBase
              value={inputValue}
              onChange={handleChange}
              onKeyDown={handleKeyPress}
              placeholder="Search…"
              inputProps={{ 'aria-label': 'search' }}
            />
          </Search>
          <Box ml="auto">
            <ThemeUpdater />
          </Box>
        </Toolbar>
      </Box>
      {renderMobileMenu}
      {renderMenu}
    </>
  );
};
