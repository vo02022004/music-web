import Typography from '@mui/material/Typography';
import Box from '@mui/material/Box';
import Button from '@mui/material/Button';
import Link from '@/components/Link';
import ProTip from '@/components/ProTip';
import { Copyright } from '@/components';
import { type NextPageWithLayout } from './_app';
import { Layout } from '@/layouts';

// Trang giới thiệu với layout được xác định.
const AboutPage: NextPageWithLayout = () => {
  return (
    <>
      {/* Phần nội dung của trang */}
      <Box
        sx={{
          my: 4, // margin top và bottom là 4
          display: 'flex', // sử dụng flexbox
          flexDirection: 'column', // hướng dọc
          justifyContent: 'center', // căn giữa theo chiều dọc
          alignItems: 'center', // căn giữa theo chiều ngang
        }}
      >
        {/* Tiêu đề */}
        <Typography variant="h4" component="h1" gutterBottom>
          Material UI - Next.js example in TypeScript
        </Typography>
        {/* Nút điều hướng */}
        <Box maxWidth="sm"> {/* Box với chiều rộng tối đa là sm */}
          <Button variant="contained" component={Link} noLinkStyle href="/">
            Go to the home page
          </Button>
        </Box>
        {/* Mẹo chuyên môn */}
        <ProTip />
        {/* Bản quyền */}
        <Copyright />
      </Box>
    </>
  );
};

// Xác định layout cho trang.
AboutPage.getLayout = (page) => <Layout>{page}</Layout>;

// Xuất AboutPage để sử dụng ở nơi khác.
export default AboutPage;
