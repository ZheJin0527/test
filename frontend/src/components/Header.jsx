'use client';

import { useState, useEffect, useRef } from 'react';
import Link from 'next/link';
import { usePathname, useRouter } from 'next/navigation';
import Image from 'next/image';

export default function Header({ showPageIndicator = false, totalSlides = 4 }) {
  const pathname = usePathname();
  const router = useRouter();
  
  // 语言检测
  const isEnglish = pathname.startsWith('/en');
  const currentLang = isEnglish ? 'en' : 'zh';
  
  // 状态管理
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const [loginDropdownOpen, setLoginDropdownOpen] = useState(false);
  const [languageDropdownOpen, setLanguageDropdownOpen] = useState(false);
  const [brandsDropdownOpen, setBrandsDropdownOpen] = useState(false);
  const [activeSlide, setActiveSlide] = useState(0);
  
  // Refs for hover timeout
  const loginTimeoutRef = useRef(null);
  const languageTimeoutRef = useRef(null);
  
  // 导航链接配置
  const navLinks = currentLang === 'en' 
    ? [
        { href: '/en', label: 'Home' },
        { href: '/en/about', label: 'About Us' },
        { href: '#', label: 'Our Brands', hasDropdown: true },
        { href: '/en/joinus', label: 'Join Us' },
      ]
    : [
        { href: '/', label: '首页' },
        { href: '/about', label: '关于我们' },
        { href: '#', label: '旗下品牌', hasDropdown: true },
        { href: '/joinus', label: '加入我们' },
      ];
  
  // 品牌下拉菜单项（可根据实际情况填充）
  const brandItems = [
    // { href: '/tokyo-japanese-cuisine', label: 'Tokyo Japanese Cuisine' },
    // { href: '/tokyo-izakaya', label: 'Tokyo Izakaya Japanese Cuisine' },
  ];
  
  // 语言切换函数
  const switchLanguage = (lang) => {
    const currentPath = pathname;
    let newPath = '';
    
    if (lang === 'en') {
      // 切换到英文
      newPath = currentPath.startsWith('/en') ? currentPath : `/en${currentPath}`;
    } else {
      // 切换到中文
      newPath = currentPath.replace(/^\/en/, '') || '/';
    }
    
    router.push(newPath);
    setLanguageDropdownOpen(false);
  };
  
  // ESC 键关闭所有下拉菜单
  useEffect(() => {
    const handleEscape = (e) => {
      if (e.key === 'Escape') {
        setMobileMenuOpen(false);
        setLoginDropdownOpen(false);
        setLanguageDropdownOpen(false);
        setBrandsDropdownOpen(false);
      }
    };
    
    document.addEventListener('keydown', handleEscape);
    return () => document.removeEventListener('keydown', handleEscape);
  }, []);
  
  // 点击外部关闭下拉菜单
  useEffect(() => {
    const handleClickOutside = (e) => {
      const target = e.target;
      if (!target.closest('.login-dropdown')) {
        setLoginDropdownOpen(false);
      }
      if (!target.closest('.language-dropdown')) {
        setLanguageDropdownOpen(false);
      }
      if (!target.closest('.brands-dropdown')) {
        setBrandsDropdownOpen(false);
      }
      if (!target.closest('.mobile-menu') && !target.closest('.hamburger-btn')) {
        setMobileMenuOpen(false);
      }
    };
    
    document.addEventListener('click', handleClickOutside);
    return () => document.removeEventListener('click', handleClickOutside);
  }, []);
  
  // 登录下拉菜单 hover 处理
  const handleLoginMouseEnter = () => {
    if (loginTimeoutRef.current) clearTimeout(loginTimeoutRef.current);
    setLoginDropdownOpen(true);
  };
  
  const handleLoginMouseLeave = () => {
    loginTimeoutRef.current = setTimeout(() => {
      setLoginDropdownOpen(false);
    }, 100);
  };
  
  // 语言下拉菜单 hover 处理
  const handleLanguageMouseEnter = () => {
    if (languageTimeoutRef.current) clearTimeout(languageTimeoutRef.current);
    setLanguageDropdownOpen(true);
  };
  
  const handleLanguageMouseLeave = () => {
    languageTimeoutRef.current = setTimeout(() => {
      setLanguageDropdownOpen(false);
    }, 200);
  };
  
  return (
    <>
      {/* Header Navbar */}
      <header className="fixed top-0 left-0 w-full h-[50px] lg:h-20 px-[44px] lg:px-[70px] lg:pr-20 bg-[#2F2F2F] text-white z-[999] flex justify-between items-center transition-transform duration-300 ease-in-out">
        
        {/* Logo Section */}
        <div className="flex items-center">
          <Link href={isEnglish ? '/en' : '/'}>
            <Image 
              src="/images/logo.png" 
              alt="KUNZZ Logo" 
              width={150}
              height={52}
              className="h-[38px] lg:h-[52px] w-auto"
              priority
            />
          </Link>
        </div>
        
        {/* Desktop Navigation */}
        <nav className="hidden lg:flex items-center gap-5 xl:gap-[30px] h-20 font-light text-xs xl:text-base ml-9">
          {navLinks.map((link, index) => (
            <div key={index} className="relative h-full">
              {link.hasDropdown ? (
                <div 
                  className="brands-dropdown h-full"
                  onMouseEnter={() => setBrandsDropdownOpen(true)}
                  onMouseLeave={() => setBrandsDropdownOpen(false)}
                >
                  <span className="flex items-center justify-center h-full px-1 cursor-pointer transition-all duration-300 hover:bg-[#FF5C00] hover:px-[30px] whitespace-nowrap">
                    {link.label}
                  </span>
                  
                  {/* Brands Dropdown Menu */}
                  {brandItems.length > 0 && (
                    <div className={`
                      absolute top-[84%] left-0 mt-2 min-w-[220px]
                      bg-[#2F2F2F] rounded-lg shadow-[0_8px_25px_rgba(0,0,0,0.15)]
                      overflow-hidden transition-all duration-300 z-[1000]
                      ${brandsDropdownOpen ? 'opacity-100 visible translate-y-0' : 'opacity-0 invisible -translate-y-2'}
                    `}>
                      {brandItems.map((brand, idx) => (
                        <Link
                          key={idx}
                          href={brand.href}
                          className="block px-3 py-[6px] text-[10px] text-white hover:bg-[#FF5C00] transition-colors border-b border-[#444] last:border-b-0"
                        >
                          {brand.label}
                        </Link>
                      ))}
                    </div>
                  )}
                </div>
              ) : (
                <Link 
                  href={link.href}
                  className={`
                    flex items-center justify-center h-full px-1
                    transition-all duration-300 hover:bg-[#FF5C00] hover:px-[30px]
                    whitespace-nowrap
                    ${pathname === link.href ? 'bg-[#FF5C00] px-[30px]' : ''}
                  `}
                >
                  {link.label}
                </Link>
              )}
            </div>
          ))}
        </nav>
        
        {/* Right Section */}
        <div className="flex items-center gap-0 lg:gap-8">
          
          {/* Login Button (Desktop) */}
          <div 
            className="hidden lg:block relative login-dropdown ml-[85px] lg:ml-0"
            onMouseEnter={handleLoginMouseEnter}
            onMouseLeave={handleLoginMouseLeave}
          >
            <button className="w-[60px] lg:w-[100px] h-[18px] lg:h-[26px] bg-[#FF5C00] text-white border-none rounded-[17px] lg:rounded-full px-3 lg:px-[25px] text-[10px] lg:text-sm cursor-pointer hover:bg-[#d87b00] transition-colors leading-[11px] lg:leading-[26px]">
              {isEnglish ? 'Login' : '登入'}
            </button>
            
            {/* Login Dropdown Menu */}
            <div className={`
              absolute top-[80%] left-0 lg:left-0 mt-2 w-[80px] lg:w-[120px]
              bg-[#2F2F2F] rounded-lg shadow-[0_8px_25px_rgba(0,0,0,0.15)]
              overflow-hidden transition-all duration-300 z-[1000]
              ${loginDropdownOpen ? 'opacity-100 visible translate-y-0' : 'opacity-0 invisible -translate-y-2'}
            `}>
              <Link
                href={isEnglish ? '/en/login' : '/login'}
                className="block px-3 lg:px-5 py-[6px] lg:py-2.5 text-[10px] lg:text-sm text-white hover:bg-[#FF5C00] transition-colors"
                onClick={() => setLoginDropdownOpen(false)}
              >
                {isEnglish ? 'Staff Login' : '员工登入'}
              </Link>
            </div>
          </div>
          
          {/* Language Switcher */}
          <div 
            className="relative language-dropdown ml-[30px] lg:ml-0 -mr-5 lg:mr-0"
            onMouseEnter={handleLanguageMouseEnter}
            onMouseLeave={handleLanguageMouseLeave}
          >
            <button className="w-[60px] lg:w-[100px] h-[18px] lg:h-[26px] bg-transparent text-white border border-[#FF5C00] rounded-[17px] lg:rounded-full px-3 lg:px-[25px] text-[10px] lg:text-sm cursor-pointer hover:bg-[#FF5C00] transition-colors leading-[1px] lg:leading-[26px]">
              {isEnglish ? 'English' : '中文'}
            </button>
            
            {/* Language Dropdown Menu */}
            <div className={`
              absolute top-[80%] -right-10 lg:right-0 mt-2 w-[80px] lg:w-[120px]
              bg-[#2F2F2F] rounded-lg shadow-[0_8px_25px_rgba(0,0,0,0.15)]
              overflow-hidden transition-all duration-300 z-[1000]
              ${languageDropdownOpen ? 'opacity-100 visible translate-y-0' : 'opacity-0 invisible -translate-y-2'}
            `}>
              <button
                onClick={() => switchLanguage('zh')}
                className="block w-full px-3 lg:px-5 py-[6px] lg:py-2.5 text-[10px] lg:text-sm text-white text-left hover:bg-[#FF5C00] transition-colors border-b border-[#444]"
              >
                中文
              </button>
              <button
                onClick={() => switchLanguage('en')}
                className="block w-full px-3 lg:px-5 py-[6px] lg:py-2.5 text-[10px] lg:text-sm text-white text-left hover:bg-[#FF5C00] transition-colors"
              >
                English
              </button>
            </div>
          </div>
          
          {/* Hamburger Menu (Mobile) */}
          <button 
            className="lg:hidden text-xl sm:text-2xl hamburger-btn"
            onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
            aria-label="Toggle menu"
          >
            ☰
          </button>
        </div>
        
      </header>
      
      {/* Mobile Navigation Menu */}
      <nav className={`
        lg:hidden fixed top-[50px] sm:top-[50px] left-0 w-full h-[40vh]
        bg-[#2F2F2F] flex flex-col items-center justify-start
        px-8 sm:px-10 py-4 sm:py-6 gap-6 sm:gap-8 z-[1000]
        transition-all duration-300 ease-in-out mobile-menu
        ${mobileMenuOpen ? 'translate-y-0 opacity-100' : '-translate-y-[160%] opacity-0'}
      `}>
        {navLinks.map((link, index) => (
          <div key={index} className="w-full">
            {link.hasDropdown && brandItems.length > 0 ? (
              <div className="w-full">
                <button 
                  onClick={() => setBrandsDropdownOpen(!brandsDropdownOpen)}
                  className="w-full py-2 text-xs sm:text-sm text-center text-white border-b border-white/10"
                >
                  {link.label}
                </button>
                {brandsDropdownOpen && (
                  <div className="pl-4 mt-2 space-y-2">
                    {brandItems.map((brand, idx) => (
                      <Link
                        key={idx}
                        href={brand.href}
                        className="block py-1 text-xs sm:text-sm text-white/80"
                        onClick={() => setMobileMenuOpen(false)}
                      >
                        {brand.label}
                      </Link>
                    ))}
                  </div>
                )}
              </div>
            ) : (
              <Link 
                href={link.href}
                className="block w-full py-2 text-xs sm:text-sm text-center text-white border-b border-white/10"
                onClick={() => setMobileMenuOpen(false)}
              >
                {link.label}
              </Link>
            )}
          </div>
        ))}
        
        {/* Mobile Login Button */}
        <Link
          href={isEnglish ? '/en/login' : '/login'}
          className="mt-auto mb-5 w-[100px] h-8 bg-[#FF5C00] text-white rounded-full text-xs sm:text-sm flex items-center justify-center hover:bg-[#d87b00] transition-colors"
          onClick={() => setMobileMenuOpen(false)}
        >
          {isEnglish ? 'Login' : '登入'}
        </Link>
      </nav>
      
      {/* Page Indicator (Optional) */}
      {showPageIndicator && (
        <div className="hidden lg:flex fixed left-[1.875rem] top-1/2 -translate-y-1/2 z-[1000] flex-col gap-3 p-4 px-2.5 bg-[rgba(50,50,50,0.3)] rounded-[1.75rem] backdrop-blur-md border border-white/15 opacity-50 hover:opacity-100 transition-opacity duration-800">
          {Array.from({ length: totalSlides }).map((_, index) => (
            <div
              key={index}
              data-slide={index}
              onClick={() => setActiveSlide(index)}
              className={`
                cursor-pointer transition-all duration-400 relative
                ${activeSlide === index 
                  ? 'w-[0.15rem] h-6 rounded-md bg-white border-white' 
                  : 'w-[0.15rem] h-[0.15rem] rounded-full bg-white/80 border-white/80 hover:scale-130'
                }
              `}
            />
          ))}
        </div>
      )}
    </>
  );
}