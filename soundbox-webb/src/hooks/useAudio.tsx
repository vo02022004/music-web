import {
  type Dispatch,
  type PropsWithChildren,
  type SetStateAction,
  createContext,
  useContext,
  useState,
} from 'react';

// Định nghĩa một interface để mô tả các thuộc tính của một đối tượng âm thanh.
interface IAudio {
  // Đường dẫn của file âm thanh.
  url?: string;
  // Hàm để cập nhật đường dẫn của file âm thanh.
  setUrl: Dispatch<SetStateAction<string | undefined>>;
}

// Giá trị mặc định của đối tượng âm thanh.
const defaultvalue: IAudio = {
  setUrl: () => {}, // Một hàm trống để mặc định.
};

// Tạo một Context để quản lý trạng thái âm thanh và cung cấp cho các thành phần con.
const AudioContext = createContext<IAudio>(defaultvalue);

// Component Provider cho âm thanh, nơi nó cung cấp trạng thái và hàm cập nhật cho các thành phần con.
export const AudioProvider = ({ children }: PropsWithChildren) => {
  // Sử dụng useState để lưu trữ đường dẫn hiện tại của âm thanh.
  const [url, setUrl] = useState<string>();

  return (
    // Cung cấp trạng thái và hàm cập nhật cho các thành phần con thông qua Context.Provider.
    <AudioContext.Provider
      value={{
        url,    // Trạng thái hiện tại của âm thanh.
        setUrl, // Hàm cập nhật trạng thái của âm thanh.
      }}
    >
      {children} {/* Hiển thị các thành phần con */}
    </AudioContext.Provider>
  );
};

// Hook để sử dụng trạng thái và hàm cập nhật của âm thanh trong các thành phần con.
export const useAudio = () => useContext(AudioContext);
