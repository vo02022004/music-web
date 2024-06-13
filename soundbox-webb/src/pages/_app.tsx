import { type AppProps } from 'next/app';
import { type EmotionCache } from '@emotion/react';
import createEmotionCache from '@/createEmotionCache';
import PageProvider from '@/components/helpers/PageProvider';
import { type NextPage } from 'next';
import { useState, type ReactElement, type ReactNode } from 'react';
import { AudioProvider } from '@/hooks/useAudio';
import {
  HydrationBoundary,
  QueryClient,
  QueryClientProvider,
} from '@tanstack/react-query';

import 'react-toastify/dist/ReactToastify.css';
import 'slick-carousel/slick/slick.css';
import 'slick-carousel/slick/slick-theme.css';
import { ToastContainer } from 'react-toastify';

// Client-side cache, shared for the whole session of the user in the browser.
const clientSideEmotionCache = createEmotionCache();

export type NextPageWithLayout<P = Record<string, unknown>> = NextPage<P> & {
  // Định nghĩa một thuộc tính tùy chọn để lấy giao diện trang
  getLayout?: (page: ReactElement) => ReactNode;
};

export interface MyAppProps extends AppProps {
  emotionCache?: EmotionCache;
}

export type AppPropsWithLayout = MyAppProps & {
  // Kế thừa AppProps và thêm một thuộc tính Component kiểu NextPageWithLayout
  Component: NextPageWithLayout;
};

// Component chính của ứng dụng, nhận các props và render giao diện
export default function MyApp(props: AppPropsWithLayout) {
  const { Component, emotionCache = clientSideEmotionCache, pageProps } = props;

  // Lấy ra hàm getLayout từ Component hoặc sử dụng hàm mặc định nếu không tồn tại
  const getLayout = Component.getLayout ?? ((page) => page);

  // Sử dụng useState để tạo một query client cho ứng dụng
  const [queryClient] = useState(() => new QueryClient());

  return (
    <QueryClientProvider client={queryClient}>
      {/* Sử dụng HydrationBoundary để đảm bảo dữ liệu đã được hydrate */}
      <HydrationBoundary state={pageProps.dehydratedState}>
        {/* Sử dụng PageProvider để cung cấp emotionCache cho trang */}
        <PageProvider emotionCache={emotionCache}>
          {/* Sử dụng AudioProvider để cung cấp chức năng liên quan tới âm thanh */}
          <AudioProvider>
            {/* Hiển thị ToastContainer để hiển thị thông báo */}
            <ToastContainer />
            {/* Lấy giao diện của Component và truyền vào hàm getLayout */}
            {getLayout(<Component {...pageProps} />)}
          </AudioProvider>
        </PageProvider>
      </HydrationBoundary>
    </QueryClientProvider>
  );
} 

