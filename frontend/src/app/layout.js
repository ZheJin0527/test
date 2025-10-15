// app/layout.js
import './globals.css'; // 👈 重要！必须导入
import Header from '@/components/Header';

export default function RootLayout({ children }) {
  return (
    <html lang="zh">
      <body>
        <Header />
        <main className="pt-[50px] lg:pt-20">
          {children}
        </main>
      </body>
    </html>
  );
}