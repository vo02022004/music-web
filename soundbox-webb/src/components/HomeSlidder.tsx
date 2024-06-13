
import Image from 'next/image';
import React from 'react';
import { Box } from '@mui/material';
import Slider, { type Settings } from 'react-slick';

import img1 from '../../public/banner1.jpeg'
import img2 from '../../public/banner2.jpeg'
import img3 from '../../public/banner3.jpeg'
import img4 from '../../public/banner4.jpeg'
import img5 from '../../public/banner5.jpeg'
import img6 from '../../public/banner6.jpeg'

export function HomeSlider() {
  // Cài đặt cho slider
  const settings: Settings = {
    dots: true,
    dotsClass: 'slick-dots',
    infinite: true,
    speed: 500,
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
  };

  return (
    <Box
      component={Slider}
      {...settings}
      sx={{
        // CSS tùy chỉnh cho các dấu chấm của slider
        '.slick-dots': {
          bottom: '20px',
          li: {
            width: 'unset',
            height: 'unset',
            button: {
              width: '20px',
              height: '20px',
              borderRadius: '40px',
              ':before': {
                content: 'unset',
              },
              backgroundColor: 'rgba(255, 255, 255, 0.5)',
              transition: 'width 0.33s linear',
            },
            margin: '0 5px',
            '&.slick-active': {
              button: {
                backgroundColor: '#fff',
                width: '40px',
                height: '20px',
              },
            },
          },
        },
      }}
    >
      {/* Các slide của slider */}
      <Box sx={{position: "relative", width: "100%", aspectRatio: "16/9"}}>
        <Image className='ahihihi' sizes='100vw' fill src={img1} alt="slider"  style={{ objectFit: 'cover', height: "100%" }} placeholder='blur' />
      </Box>
      <Box sx={{position: "relative", width: "100%", aspectRatio: "16/9"}}>
        <Image className='ahihihi' sizes='100vw' fill src={img2} alt="slider"  style={{ objectFit: 'cover', height: "100%" }} placeholder='blur' />
      </Box>
      <Box sx={{position: "relative", width: "100%", aspectRatio: "16/9"}}>
        <Image className='ahihihi' sizes='100vw' fill src={img3} alt="slider"  style={{ objectFit: 'cover', height: "100%" }} placeholder='blur' />
      </Box>
      <Box sx={{position: "relative", width: "100%", aspectRatio: "16/9"}}>
        <Image className='ahihihi' sizes='100vw' fill src={img4} alt="slider"  style={{ objectFit: 'cover', height: "100%" }} placeholder='blur' />
      </Box>
      <Box sx={{position: "relative", width: "100%", aspectRatio: "16/9"}}>
        <Image className='ahihihi' sizes='100vw' fill src={img5} alt="slider"  style={{ objectFit: 'cover', height: "100%" }} placeholder='blur' />
      </Box>
      <Box sx={{position: "relative", width: "100%", aspectRatio: "16/9"}}>
        <Image className='ahihihi' sizes='100vw' fill src={img6} alt="slider"  style={{ objectFit: 'cover', height: "100%" }} placeholder='blur' />
      </Box>
      {/* Các slide bổ sung (nếu cần) */}
      {/* <div>
        <img src="/banner2.jpeg" alt="" style={{ width: '100%' }} />
      </div>
      <div>
        <img src="/banner3.jpeg" alt="" style={{ width: '100%' }} />
      </div>
      <div>
        <img src="/banner4.jpeg" alt="" style={{ width: '100%' }} />
      </div>
      <div>
        <img src="/banner5.jpeg" alt="" style={{ width: '100%' }} />
      </div>
      <div>
        <img src="/banner6.jpeg" alt="" style={{ width: '100%' }} />
      </div> */}
    </Box>
  );
}

