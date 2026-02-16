<!-- <div id="preloaderr">
    <div id="status">&nbsp;</div>
</div> -->

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
<style>
    .shop-by-bike>#shop-title {
        text-transform: capitalize !important;
    }

    .sm_user>span {
        font-size: 15px;
        color: #798f35;
        font-weight: bold;

    }

    #nav-header {
        padding-right: 25px;
        padding-left: 25px;
    }

    header {

        /* Position the image at the center */
        /* padding: 20px 0; */
        /* position: absolute;
    top: 0; */
        /* background-image: url(file:///C:/Users/Appteq/Downloads/wallpaperflare.com_wallpaper%20(2).jpg); */
    }

    nav {
        margin: 0;
        padding: 0;
        height: 40px;
    }

    header section {
        padding: 0;
        height: 0;
        margin-top: 0 !important;
    }

    /* body.darkmode {
    color: #fff;
    background-color: var(--color2-dark);
} */

    /* main {
    overflow: hidden;
} */
    /* 
a,
button {
    cursor: pointer;
    user-select: none;
    border: none;
    outline: none;
    background: none;
} */

    /* img,
video {
    display: block;
    max-width: 100%;
    height: auto;
    object-fit: cover;
} */

    /* img {
    image-rendering: -webkit-optimize-contrast;
    image-rendering: -moz-crisp-edges;
    image-rendering: crisp-edges;
} */

    /* @keyframes slideLeft {
    0% {
        opacity: 0;
        transform: translateX(100%);
    }

    100% {
        opacity: 1;
        transform: translateX(0%);
    }
}

@keyframes slideRight {
    0% {
        opacity: 1;
        transform: translateX(0%);
    }

    100% {
        opacity: 0;
        transform: translateX(100%);
    }
} */

    /* .section {
    margin: 0 auto;
    padding: 6rem 0 2rem;
} */

    /* .container {
    max-width: 75rem;
    height: auto;
    margin-inline: auto;
    padding-inline: 1.5rem;
} */

    /* .centered {
    text-align: center;
    vertical-align: middle;
    margin-bottom: 1rem;
} */

    /* .header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: auto;
    z-index: 100;
    margin: 0 auto;
    background-color: #fff;
    box-shadow: var(--shadow-medium);
} */

    /* .darkmode .header {
    background-color: var(--color2);
} */

    .navbar {
        display: flex;
        flex-wrap: wrap;
        align-content: center;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        /* height: 65px; */
        margin: 0 auto;
    }

    .navbar .navbar__left {
        display: flex;
        align-items: center;
        /* flex: 0 0 17%; */
    }

    /* @media (max-width: 766px) {
    .navbar .navbar__left {
        flex: 0 0 auto;
    }

    .login_li {
        display: none !important;
    }
} */

    .navbar .navbar__center {
        display: flex;
    }

    @media (max-width: 766px) {
        .navbar .navbar__center {
            flex: 0 0 100%;
            order: 3;
            align-items: center;
        }

        /* .submenu.megamenu__text {
        width: 100%;
    }

    .menu__dropdown .submenu {
        max-height: inherit;
    } */
    }


    /* @media (max-width: 766px) {
    .navbar .navbar__right {
        flex: 0 0 auto;
        align-items: center;
    }
} */

    /* .brand {
    display: flex;
    align-items: center;
    order: 1;
} */

    .brand svg {
        width: 60px;
        height: 60px;
    }

    @media (max-width: 766px) {
        .menu {
            position: fixed;
            top: 0;
            left: 0;
            width: 265px;
            max-width: 85%;
            height: 100%;
            z-index: 100;
            overflow: hidden;
            background-color: #fff;
            transform: translate(-100%);
            transition: all 0.4s ease-in-out;
        }

        .menu.is-active {
            transform: translate(0%);
            margin-top: 75px;
        }

        .darkmode .menu {
            background-color: var(--color2);
        }
    }

    .menu .menu__header {
        display: none;
        box-shadow: var(--shadow-medium);
    }

    @media (max-width: 766px) {
        .menu .menu__header {
            position: relative;
            top: 0;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            height: 1rem;
            z-index: 110;
            visibility: hidden;
            background: transparent;
        }

        .menu .menu__header.is-active {
            visibility: visible;
            background-color: #fff;
            padding: 20px 0;
        }

        .menu .menu__header.is-active>.menu__arrow {
            display: flex;
        }

        .darkmode .menu .menu__header.is-active {
            background-color: var(--color2);
        }
    }

    @media (max-width: 766px) {
        .menu .menu__header .menu__arrow {
            display: none;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            width: 3rem;
        }

        .menu .menu__header .menu__arrow:hover i {
            color: var(--color);
        }

        .menu .menu__header .menu__arrow>i {
            font-size: 1.5rem;
            color: #000;
            transition: all 0.25s ease;
        }

        .darkmode .menu .menu__header .menu__arrow>i {
            color: #fff;
        }
    }

    @media (max-width: 766px) {
        .menu .menu__header .menu__title {
            cursor: pointer;
            font-weight: 500;
            text-transform: capitalize;
            color: #fff;
            transition: all 0.25s ease;
            font-size: 14px;
        }

        .menu .menu__header .menu__title:hover {
            color: var(--color);
        }

        .darkmode .menu .menu__header .menu__title {
            color: #fff;
        }
    }

    @media (max-width: 766px) {
        .menu .menu__inner {
            height: 100%;
            /* margin-top: -3rem; */
            overflow-y: auto;
            overflow-x: hidden;
            display: block;
        }
    }



    .menu .menu__inner .menu__item:last-child {
        padding-right: 0;
    }

    .menu .menu__inner .menu__item:hover>.menu__link {
        color: #a1c530;
    }

    .darkmode .menu .menu__inner .menu__item:hover>.menu__link {
        color: #a1c530;
    }

    @media (max-width: 766px) {
        .menu .menu__inner .menu__item {
            display: block;
            padding: 0;
        }
    }

    @media (min-width: 768px) {
        .menu .menu__inner .menu__item:hover>.menu__link i {
            transform: rotate(-90deg);
        }
    }

    @media (min-width: 768px) {
        .menu .menu__inner .menu__item.menu__dropdown:hover>.submenu {
            opacity: 1;
            visibility: visible;
            top: 95%;
        }
    }

    .menu .menu__inner .menu__item .menu__link {
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 13px;
        font-weight: 500;
        text-transform: capitalize;
        transition: all 0.25s ease;
    }

    @media (max-width: 766px) {
        .menu .menu__inner .menu__item .menu__link {
            justify-content: space-between;
            padding: 20px;
        }
    }

    .menu .menu__inner .menu__item .menu__link>i {
        margin-left: 5px;
        font-size: 1.35rem;
        transform: rotate(90deg);
        transition: 0.35s;
    }

    @media (max-width: 766px) {
        .menu .menu__inner .menu__item .menu__link>i {
            margin-left: 10px;
            transform: rotate(0deg);
        }
    }

    .darkmode .menu .menu__inner .menu__item .menu__link {
        color: #fff;
    }

    .submenu {
        position: absolute;
        z-index: 100;
        top: 110%;
        left: 50%;
        width: 100%;
        height: auto;
        padding: 20px 15px;
        border-radius: 0.25rem;
        border-top: 2px solid var(--color);
        background-color: #fff;
        box-shadow: var(--shadow-medium);
        opacity: 0;
        visibility: hidden;
        transition: all 0.35s ease-in-out;
        transform: translateX(-50%);
    }

    .darkmode .submenu {
        border-top: 2px solid var(--color);
        background-color: var(--color2);
    }

    @media (max-width: 766px) {
        .submenu {
            position: absolute;
            display: none;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            max-width: none;
            min-width: auto;
            margin: 0;
            padding: 100px 15px 0 15px;
            border-radius: 0;
            border-top: 0;
            box-shadow: none;
            opacity: 1;
            overflow-y: auto;
            visibility: visible;
            transform: translateX(0%);
        }

        .submenu.is-active {
            display: block;
        }
    }

    @media (min-width: 768px) {
        .submenu {
            animation: none !important;
        }
    }

    @media (min-width: 767px) {
        .submenu.megamenu__normal {
            left: 65%;
            max-width: 250px;
            width: 100%;
            height: auto;
            margin: 0 auto;
        }
    }

    @media (min-width: 767px) {

        .submenu.megamenu__text,
        .submenu.megamenu__image {
            display: flex;
            flex-wrap: wrap;
            max-width: 95%;
            height: auto;
            margin: 0 auto;
        }




    }

    @media (min-width: 975px) {

        .submenu.megamenu__text,
        .submenu.megamenu__image {
            max-width: 100%;
        }
    }

    .submenu.megamenu__image .submenu__inner a {
        display: flex;
        flex-flow: column;
        align-items: center;
    }

    @media (max-width: 766px) {
        .submenu.megamenu__image .submenu__inner a {
            flex-flow: row;
            align-items: center;
            padding-bottom: 20px;
        }
    }

    .submenu.megamenu__image .submenu__inner a img {
        display: block;
        width: 100%;
        height: 150px;
        margin-bottom: 15px;
        object-fit: cover;
        border-radius: 10px;
    }

    @media (max-width: 766px) {
        .submenu.megamenu__image .submenu__inner a img {
            width: 30%;
            height: 80px;
            margin-bottom: 0;
            margin-right: 15px;
        }
    }

    .submenu .submenu__inner {
        width: 20%;
        padding: 0 15px 30px 0;
    }

    @media (max-width: 766px) {
        .submenu .submenu__inner {
            width: 100%;
            padding: 15px;
        }

        .submenu .submenu__list {
            margin-bottom: 0px !important;
        }
    }

    .submenu .submenu__inner .submenu__title {
        margin-bottom: 12px;
        font-size: 17px;
        font-weight: 500;
        color: var(--color);
        text-transform: capitalize;
        transition: all 0.3s ease;
    }

    .darkmode .submenu .submenu__inner .submenu__title {
        color: var(--color) !important;
    }

    @media (max-width: 766px) {
        .submenu .submenu__list {
            margin-bottom: 20px;
        }
    }

    .submenu .submenu__list li {
        display: block;
        line-height: 1;
        text-transform: capitalize !important;
        margin: 0 auto;
    }

    .submenu .submenu__list li a {
        display: inline-block;
        padding: 8px 0;
        line-height: 1;
        text-transform: capitalize !important;
        color: #000;
        transition: all 0.25s ease-in-out;
    }

    .submenu .submenu__list li a:hover {
        color: var(--color);
    }

    @media (max-width: 766px) {
        .submenu .submenu__list li a {
            display: block;
        }
    }

    .darkmode .submenu .submenu__list li a {
        color: #fff;
    }

    .darkmode .submenu .submenu__list li a:hover {
        color: var(--color);
    }

    .switch {
        position: relative;
        display: block;
        cursor: pointer;
        user-select: none;
        margin-right: 10px;
    }

    .switch .switch__light,
    .switch .switch__dark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform-origin: center;
        transform: translate(-50%, -50%);
        transition: all 0.3s ease-in;
    }

    .switch .switch__light {
        font-size: 20px;
        visibility: visible;
        color: #000;
    }

    .darkmode .switch .switch__light {
        font-size: 0;
        visibility: hidden;
    }

    .switch .switch__dark {
        font-size: 0;
        visibility: hidden;
        color: #fff;
    }

    .darkmode .switch .switch__dark {
        font-size: 20px;
        visibility: visible;
    }

    .overlay {
        position: fixed;
        display: block;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9;
        opacity: 0;
        visibility: hidden;
        background-color: rgba(0, 0, 0, 0.7);
        transition: all 0.45s ease-in-out;
        pointer-events: none;
    }

    @media (max-width: 766px) {
        .overlay {
            cursor: url("http://localhost/adventurenew/final-adventure-shopppe/public/assets/images/icons/close-cursor.png"), zoom-out;
            pointer-events: visible;
        }

        .overlay.is-active {
            opacity: 1;
            visibility: visible;
        }
    }

    .burger {
        position: relative;
        display: block;
        cursor: pointer;
        width: 25px;
        height: 15px;
        margin-right: 15px;
        opacity: 0;
        visibility: hidden;
        background: transparent;
    }

    @media (max-width: 766px) {
        .burger {
            opacity: 1;
            visibility: visible;
        }

        .menu-lg {
            display: none !important;
        }

        .login_li {
            bottom: 0;
            position: absolute;
        }

        .login_li .menu__link {
            font-size: 25px;
        }

        .demo-icon-wrap-s2 span.icon_close {
            text-align: end;
            background-color: transparent;
        }

        .icon_profile {
            padding: 0;
            display: flex !important;
            align-items: center !important;
            justify-content: end !important;
        }

        .icon_profile:before {
            border: 1px solid;
            border-radius: 50%;
            padding: 5px;
            font-size: 10px;
        }
    }

    .burger .burger-line {
        position: absolute;
        display: block;
        left: 0;
        width: 100%;
        height: 2px;
        opacity: 1;
        border-radius: 15px;
        background: #fff;
    }

    .darkmode .burger .burger-line {
        background: #fff;
    }

    .burger .burger-line:nth-child(1) {
        top: 0px;
    }

    .burger .burger-line:nth-child(2) {
        top: 8px;
        width: 70%;
    }

    .burger .burger-line:nth-child(3) {
        top: 16px;
    }

    .navbar__left img {
        width: auto;
        height: 30px;
        margin-right: 15px;
    }

    .menu-lg {
        display: block;
    }

    .hidden {
        display: none;
    }

    #switch {
        display: flex;
    }

    .brand img {
        width: auto;
        height: 110px;
    }

    .search_wrapper button {
        background-color: transparent;
        border: 1px solid #d3d3d3;
        height: 40px;
    }

    .search_wrapper input {
        height: 40px;
        width: 515px;
    }

    .search_wrapper .form-label {
        argin-left: 0px;
        /* margin: 0; */
        display: flex;
        /* align-items: center; */
        justify-content: c;
        text-transform: capitalize;
        color: #d3d3d396 !important;
    }



    .label {
        font-size: .625rem;
        font-weight: 400;
        text-transform: uppercase;
        letter-spacing: +1.3px;
        margin-bottom: 1rem;
    }

    .searchBar {
        width: 100%;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
    }

    /* krish */
    #search_bar {
        width: 80%;
        height: 2.8rem;
        background: #fff;
        outline: none;
        color: #000;
        border: none;
        border-radius: 4px;
        padding: 0 3.5rem 0 1.0rem;
        font-size: 14px;
        height: 37px;
        text-align: start;
        margin-bottom: 2px;
    }


    #searchQuerySubmit {
        width: 3.5rem;
        height: 37px;
        margin-left: -3.5rem;
        background: none;
        border: none;
        outline: none;
        background-color: #a1c530;
        border-radius: 0 4px 4px 0;
        margin-bottom: 2px;
    }

    #searchQuerySubmit:hover {
        background-color: #8aa928 !important;
    }

    @media (min-width: 992px) {
        .brand img {
            margin-left: 38px;
        }

    }

    @media (max-width: 768px) {
        #search_bar {
            width: 96% !important;
            height: 30px !important;
            margin-bottom: 0 !important;
        }

        #searchQuerySubmit {
            height: 42px !important;
            margin-bottom: 0 !important;
        }
    }






    /* Mobile Search  */

    /* NEW CSS FOR  */
    @media (max-width: 768px) {
        .brand img {
            margin-left: 30px;
            height: 60px !important;
            width: 100px !important;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        #burger {
            margin-left: 10px;
        }
    }

    @media only screen and (max-width: 768px) {
        .searchInput {
            margin-top: 8% !important;
        }
    }


    .mobile-only {
        display: none;
    }

    .desktop-search {
        display: block;
    }

    .desktop-search #searchQuerySubmit svg path {
        fill: #F4F4F4;
    }

    /* ---------- MOBILE ONLY ---------- */
    @media (max-width: 768px) {

        .desktop-search {
            display: none;
        }

        .mobile-only {
            display: block;
        }

        .mobile-search-slide {
            position: absolute;
            top: 101% !important;
            left: 0;
            width: 100%;
            background: #000;
            padding: 8px 12px;
            transform: translateY(-100%);
            opacity: 0;
            pointer-events: none;
            transition: transform 0.3s ease, opacity 0.3s ease;
            z-index: 9999;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);

            overflow: visible !important;

        }

        .mobile-search-slide.active {
            transform: translateY(0);
            opacity: 1;
            pointer-events: auto;
        }

        /* SEARCH BAR UI */
        .mobile-search-slide .searchInput {
            display: flex;
            align-items: center;
            height: 42px;
            background: #fff;
            border-radius: 6px;
            overflow: hidden;
        }

        .mobile-search-slide input {
            flex: 1;
            height: 100%;
            border: none;
            padding: 0 12px;
            font-size: 14px;
            outline: none;
        }

        .mobile-search-slide button {
            height: 100%;
            background: #9acd32;
            border: none;
            padding: 0 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #mobileSearch #suggestionsBox {
            display: block !important;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: #ffffff;
            color: #000000;
            z-index: 100000 !important;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            max-height: 300px;
            overflow-y: auto;
            border: 0px solid #ddd;
        }

        #mobileSearch .search-container {
            position: relative;
            width: 100%;
            margin: 0;
            padding: 0;
        }

        #mobileSearch .suggestion {
            background: #fff !important;
            border-bottom: 1px solid #eee;
        }

        .mobile-search-slide .resultBox {
            display: block !important;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: #fff !important;
            color: #000 !important;
            z-index: 999999 !important;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
    }

    /* iPhone 13 / iPhone 14 specific fixes for search suggestions dropdown */
    @media only screen and (device-width: 390px) and (device-height: 844px) and (-webkit-device-pixel-ratio: 3) {
        #mobileSearch .search-container {
            position: relative !important;
            width: 100% !important;
            overflow: visible !important;
        }

        #mobileSearch #suggestionsBox {
            position: absolute !important;
            top: 100% !important;
            left:25% !important;
            right: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            margin-top: 10px !important;
            box-sizing: border-box !important;
            overflow-x: hidden !important;
            max-height: 360px !important;
            border-radius: 4px !important;
            background: #f5f5f5 !important;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25) !important;
            z-index: 100000 !important;
        }

        #mobileSearch .suggestion-link {
            display: block !important;
            width: 100% !important;
            text-decoration: none !important;
        }

        #mobileSearch .suggestion {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 12px !important;
            box-sizing: border-box !important;
            background: #f5f5f5 !important;
            border-bottom: 1px solid #dedede !important;
        }

        #mobileSearch .suggestion-img {
            flex: 0 0 84px !important;
            width: 84px !important;
            height: 56px !important;
            object-fit: contain !important;
            margin: 0 !important;
        }

        #mobileSearch .suggestion p {
            margin: 0 !important;
            line-height: 1.35 !important;
            font-size: 15px !important;
            color: #1d1d1d !important;
            word-break: break-word !important;
        }
    }

    /* iPhone 14 Pro Max / iPhone 15 Plus / iPhone 15 specific fixes for search suggestions dropdown */
    @media only screen and (device-width: 393px) and (device-height: 852px) and (-webkit-device-pixel-ratio: 3),
    only screen and (device-width: 430px) and (device-height: 932px) and (-webkit-device-pixel-ratio: 3) {
        #mobileSearch .search-container {
            position: relative !important;
            width: 100% !important;
            overflow: visible !important;
        }

        #mobileSearch #suggestionsBox {
            position: absolute !important;
            top: 100% !important;
            left: 50% !important;
            right: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            margin-top: 10px !important;
            box-sizing: border-box !important;
            overflow-x: hidden !important;
            max-height: 360px !important;
            border-radius: 4px !important;
            background: #f5f5f5 !important;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25) !important;
            z-index: 100000 !important;
        }

        #mobileSearch .suggestion-link {
            display: block !important;
            width: 100% !important;
            text-decoration: none !important;
        }

        #mobileSearch .suggestion {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 12px !important;
            box-sizing: border-box !important;
            background: #f5f5f5 !important;
            border-bottom: 1px solid #dedede !important;
        }

        #mobileSearch .suggestion-img {
            flex: 0 0 84px !important;
            width: 84px !important;
            height: 56px !important;
            object-fit: contain !important;
            margin: 0 !important;
        }

        #mobileSearch .suggestion p {
            margin: 0 !important;
            line-height: 1.35 !important;
            font-size: 15px !important;
            color: #1d1d1d !important;
            word-break: break-word !important;
        }
    }

    #searchQuerySubmit:hover {
        cursor: pointer;
    }

    ::placeholder {
        color: #000;
        opacity: 1;
        /* Firefox */
    }

    ::-ms-input-placeholder {
        /* Edge 12-18 */
        color: #fff;
    }

    .icon_heart_alt::before {
        font-size: 21px;
    }

    @media (max-width: 768px) {
        .search-toggle.mobile-only {
            margin-left: auto;
            margin-right: 0.1rem !important;
        }

        .search-toggle.mobile-only .search-toggle-icon {
            font-size: 21px;
            line-height: 1;
        }
    }

    .header i,
    .header span {
        color: #fff !important;
    }

    /* searhbar UI  */
    .searchInput {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 4%;
    }

    #suggestionsBox {
        position: absolute;
        top: 100%;
        /* directly below input */
        left: 0;
        width: 100%;
        /* match input width */
        z-index: 9999;
        background-color: #fff;
        border: 1px solid #ddd;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        max-height: 350px;
        overflow-y: auto;
        border-radius: 0 0 4px 4px;
    }



    body.no-scroll {
        overflow: hidden;
    }

    .suggestion {
        display: flex;
        align-items: center;
        padding: 10px;
        cursor: pointer;
        font-size: 14px;
        color: #333;
        width: 100%;
        box-sizing: border-box;
    }

    .suggestion-img {
        width: 100px;
        height: 100px;
        margin-right: 15px;
        object-fit: cover;
    }

    .product-name {
        flex: 1;
        word-wrap: break-word;
        white-space: normal;
        font-size: 14px;
    }

    .suggestion:hover {
        background-color: #f1f1f1;
    }


    .no-suggestions {
        padding: 10px;
        text-align: center;
        color: #888;
    }


    body.no-scroll {
        overflow: hidden;
    }

    .search-container {
        position: relative;
        display: inline-block;
        justify-content: center;
        width: 80%;
        margin-left: 10%;
    }

    /* iOS Safari-only fixes for autocomplete dropdown scaling */
    @supports (-webkit-touch-callout: none) {

        html,
        body {
            -webkit-text-size-adjust: 100%;
            text-size-adjust: 100%;
        }

        #suggestionsBox,
        .mobile-search-slide .resultBox {
            width: 100vw;
            max-width: 100vw;
            left: 0;
            right: 0;
            box-sizing: border-box;
            overflow-x: hidden;
        }

        .search-container,
        .mobile-search-slide,
        .searchInput {
            max-width: 100vw;
            overflow-x: hidden;
        }

        .suggestion {
            min-width: 0;
        }

        .product-name {
            min-width: 0;
        }

        .suggestion-img {
            flex: 0 0 60px;
            width: 60px;
            height: 60px;
            max-width: 60px;
            max-height: 60px;
            object-fit: contain;
        }
    }

    html.iphone-device #mobileSearch input[type="search"],
    html.iphone-device .mobile-search-slide input[type="search"] {
        font-size: 16px !important;
    }
</style>
<header class="header clone nav-up" id="header">
    <nav class="navbar container m-0" id="nav-header">
        <section class="d-flex w-100 align-items-center">
            <a href="<?php echo base_url() ?>" class="brand">
                <img src="<?php echo base_url() ?>public/assets/images/logo-whiteBorder.png" class="jarallax-img"
                    alt=""></a>

            <div class="wrapper">
                <!-- K -->
                <div class="desktop-search">
                    <form action="<?php echo base_url() ?>search-data" method="get" class="mobile-search">
                        <div class="searchInput">

                            <input id="search_bar" type="search" name="search_bar" placeholder="Search"
                                onkeyup="fetchSuggestions(this)" autocomplete="off" />

                            <button id="searchQuerySubmit" type="submit" name="searchQuerySubmit">
                                <svg style="width:20px;height:18px" viewBox="0 0 24 24">
                                    <path fill="#000"
                                        d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
                                </svg>
                            </button>
                        </div>
                        <div class="search-container">
                            <div id="suggestionsBox" class="resultBox d-none"></div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="search-toggle mobile-only me-3" id="searchToggle">
                <div class="demo-icon-wrap-s2 cart_wrapper">
                    <i aria-hidden="true" class="bx bx-search search-toggle-icon"></i>
                </div>
            </div>
            <!-- K -->

            <a id="wishlist" href="<?php echo base_url() ?>wishlist ">
                <div class="demo-icon-wrap-s2 me-3 cart_wrapper">
                    <span aria-hidden="true" class="icon_heart_alt"></span>
                    <p class="cart_count" id="cart-count"> <?php echo $wishlist_count ?></p>
                </div>
            </a>
            <a id="cart" href="<?php echo base_url() ?>cart-list">
                <div class="demo-icon-wrap-s2 me-3 cart_wrapper">
                    <span aria-hidden="true" class="icon_cart_alt"></span>
                    <p class="cart_count" id="cart-count"> <?php echo $cart_count ?></p>
                </div>
            </a>


            <?php if (session()->get('loginStatus') == 'NO' && session()->get('otp_verify') == "NO"): ?>
                <a href="<?php echo base_url() ?>signup" class="menu__link lg-user">
                    <span><i id="header-icon" class="fas fa-user user-icon"></i>Login/Signup</span>
                    &nbsp;
                    &nbsp;
                </a>
            <?php elseif (session()->get('otp_verify') == "YES" && (session()->get('loginStatus') == 'YES')): ?>
                <a href="<?php echo base_url() ?>myprofile" class="menu__link lg-user">
                    <span><i id="header-icon" class="fas fa-user user-icon"></i></span>
                    <span>
                        <?php echo session()->get('username') ?>
                    </span>
                </a>
            <?php endif; ?>

            <!-- </li> -->

        </section>
    </nav>
    <!-- K -->
    <div class="mobile-search-slide mobile-only" id="mobileSearch">
        <form action="<?php echo base_url() ?>search-data" method="get" class="mobile-search">
            <div class="searchInput">

                <input id="search_bar" type="search" name="search_bar" placeholder="Search"
                    onkeyup="fetchSuggestions(this)" autocomplete="off" />

                <button id="searchQuerySubmit" type="submit" name="searchQuerySubmit">
                    <svg style="width:20px;height:18px" viewBox="0 0 24 24">
                        <path fill="#000"
                            d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
                    </svg>
                </button>
            </div>
            <div class="search-container">
                <div id="suggestionsBox" class="resultBox d-none"></div>
            </div>
        </form>
    </div>

</header>



<section class="sm-burger">

    <div class="burger" id="burger">
        <span class="burger-line"></span>
        <span class="burger-line"></span>
        <span class="burger-line"></span>
    </div>
</section>

<section class="p-0 header-mini clone ">
    <span class="overlay"></span>
    <div class="menu" id="menu">
        <div class="menu__header">
            <span class="menu__arrow"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                    viewBox="0 0 24 24">
                    <path fill="#fff" d="M13.293 6.293L7.586 12l5.707 5.707l1.414-1.414L10.414 12l4.293-4.293z" />
                </svg></span>
            <span class="menu__title"></span>
        </div>

        <ul class="menu__inner" id="menu__inner ">
            <!-- <li> -->
            <!-- <div class="menu__header"> -->
            <div class="col-lg-4 col-md-6 demo-icon-wrap-s2 d-sm-block d-lg-none d-md-none">
                <span aria-hidden="true" class="icon_close m-0" id="icon_close"></span> &nbsp;
            </div>
            <!-- </div> -->
            <!-- </li> -->
            <li class="menu__item menu__dropdown">
                <?php if (session()->get('loginStatus') == 'NO' && session()->get('otp_verify') == "NO"): ?>
                    <a href="<?php echo base_url() ?>login" class="menu__link sm_user">
                        <span><i id="header-icon" class="fas fa-user user-icon"></i>Login/Signup</span>
                        &nbsp;
                        &nbsp;
                    </a>
                <?php elseif (session()->get('otp_verify') == "YES" && (session()->get('loginStatus') == 'YES')): ?>
                    <a href="<?php echo base_url() ?>myprofile" class="menu__link sm_user">
                        <span><i id="header-icon" class="fas fa-user user-icon"></i></span>
                        <span><?php echo session()->get('username') ?></span>
                    </a>
                <?php endif; ?>
            </li>
            <li class="menu__item menu__dropdown" id="menu__item">
                <a class="menu__link">
                    SHOP BY BIKE
                    <i class="bx bx-chevron-right"></i>
                </a>
                <div class="submenu megamenu__text" id="shopby-brand">
                    <?php for ($i = 0; $i < count($brand); $i++) {
                        ?>
                        <div class="submenu__inner shop-by-bike">
                            <a
                                href='<?php echo base_url() ?>shopby-brand/<?php echo str_replace(' ', '-', strtolower($brand[$i]['brand_name'])) ?>'>
                                <div class="brand_names">
                                    <!-- <img src="<?php echo base_url() ?><?php echo $brand[$i]['brand_img'] ?>" width="25"
                                        height="25" /> -->
                                    <h4 class="submenu__title" id="shop-title">
                                        <?php echo $brand[$i]['brand_name'] ?>
                                    </h4>
                                </div>
                            </a>
                            <?php for ($j = 0; $j < count($modal); $j++) {
                                if ($modal[$j]['brand_id'] === $brand[$i]['brand_id']) { ?>
                                    <ul class="submenu__list">
                                        <li>
                                            <a
                                                href="<?php echo base_url('products/' . strtolower(str_replace([' ', '/'], '-', $modal[$j]['modal_name'])) . '/' . base64_encode($modal[$j]['modal_id'])) . '/' . base64_encode($brand[$i]['brand_id']); ?>/1">
                                                <?php echo htmlspecialchars($modal[$j]['modal_name']); ?>
                                            </a>
                                        </li>

                                    </ul>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </li>
            <li class="menu__item menu__dropdown" id="menu__item">
                <a class="menu__link">
                    MOTORCYCLE ACCESSORIES
                    <i class="bx bx-chevron-right"></i>
                </a>
                <div class="submenu megamenu__text" id="shopby-brand">
                    <?php


                    for ($i = 0; $i < count($accessories); $i++) {
                        ?>
                        <div class="submenu__inner">
                            <h4 class="submenu__title">
                                <?php echo $accessories[$i]['access_title']; ?>
                            </h4>
                            <?php
                            for ($j = 0; $j < count($sub_accessories); $j++) {
                                if ($sub_accessories[$j]['access_id'] === $accessories[$i]['access_id']) {
                                    ?>
                                    <ul class="submenu__list">
                                        <li><a
                                                href="<?php echo base_url(); ?>motor-accessories/<?php echo strtolower(str_replace(' ', '-', $sub_accessories[$j]['sub_access_name'])); ?>/<?php echo base64_encode($sub_accessories[$j]['sub_access_id']); ?>/1">
                                                <?php echo $sub_accessories[$j]['sub_access_name']; ?>
                                            </a></li>
                                    </ul>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <?php
                    } ?>
                </div>
            </li>
            <li class="menu__item menu__dropdown auto_menu" id="menu__item">
                <a class="menu__link">
                    RIDING GEAR
                    <i class="bx bx-chevron-right"></i>
                </a>
                <div class="submenu megamenu__text" id="menu__item">
                    <?php for ($i = 0; $i < count($riding_menu); $i++) { ?>
                        <div class="submenu__inner">
                            <h4 class="submenu__title">
                                <?php echo $riding_menu[$i]['r_menu'] ?>
                            </h4>
                            <?php for ($j = 0; $j < count($riding_submenu); $j++) {
                                if ($riding_submenu[$j]['r_menu_id'] === $riding_menu[$i]['r_menu_id']) { ?>
                                    <ul class="submenu__list">
                                        <li><a
                                                href="<?php echo base_url() ?>riding-accessories/<?php echo strtolower(str_replace(' ', '-', $riding_submenu[$j]['r_sub_menu'])) ?>/<?php echo base64_encode($riding_submenu[$j]['r_sub_id']) ?>/1">
                                                <?php echo $riding_submenu[$j]['r_sub_menu'] ?>
                                            </a></li>
                                    </ul>
                                <?php }
                            } ?>

                        </div>
                        <?php
                    } ?>

                </div>
            </li>
            </li>
            <li class="menu__item menu__dropdown auto_menu" id="menu__item">
                <a class="menu__link">
                    HELMET AND ACCESSORIES
                    <i class="bx bx-chevron-right"></i>
                </a>
                <div class="submenu megamenu__text" id="menu__item">
                    <?php for ($i = 0; $i < count($h_menu); $i++) { ?>
                        <div class="submenu__inner">
                            <h4 class="submenu__title">
                                <?php echo $h_menu[$i]['h_menu'] ?>
                            </h4>
                            <?php

                            for ($j = 0; $j < count($h_submenu); $j++) {
                                if ($h_submenu[$j]['h_menu_id'] === $h_menu[$i]['h_menu_id']) {

                                    // $submenuData = strtolower(str_replace(' ', '-', $h_submenu[$j]['h_submenu']));
                        
                                    // if ($submenuData == 'helmet-bluetooth') {
                                    //     continue;
                                    // }
                                    ?>
                                    <ul class="submenu__list">
                                        <li><a
                                                href="<?php echo base_url() ?>helmet-accessories/<?php echo strtolower(str_replace(' ', '-', $h_submenu[$j]['h_submenu'])) ?>/<?php echo base64_encode($h_submenu[$j]['h_submenu_id']) ?>/1">
                                                <?php echo $h_submenu[$j]['h_submenu'] ?>
                                            </a></li>
                                    </ul>
                                <?php }
                            } ?>

                        </div>
                        <?php
                    } ?>

                </div>
            </li>
            <li class="menu__item menu__dropdown auto_menu" id="menu__item">
                <a class="menu__link">
                    LUGGAGES
                    <i class="bx bx-chevron-right"></i>
                </a>
                <div class="submenu megamenu__text" id="shopby-brand">
                    <?php for ($i = 0; $i < count($lug_menu); $i++) { ?>
                        <div class="submenu__inner">
                            <h4 class="submenu__title">
                                <?php echo $lug_menu[$i]['lug_menu'] ?>
                            </h4>
                            <?php for ($j = 0; $j < count($lud_submenu); $j++) {
                                if ($lud_submenu[$j]['lug_menu_id'] === $lug_menu[$i]['lug_menu_id']) { ?>
                                    <ul class="submenu__list">
                                        <li><a
                                                href="<?php echo base_url() ?>touring-accesssories/<?php echo strtolower(str_replace(' ', '-', $lud_submenu[$j]['lug_submenu'])) ?>/<?php echo base64_encode($lud_submenu[$j]['lug_submenu_id']) ?>/1">
                                                <?php echo $lud_submenu[$j]['lug_submenu'] ?>
                                            </a>
                                        </li>
                                    </ul>
                                <?php }
                            } ?>

                        </div>
                        <?php
                    } ?>

                </div>
            </li>
            <li class="menu__item menu__dropdown auto_menu" id="menu__item">
                <a class="menu__link">
                    CAMPING
                    <i class="bx bx-chevron-right"></i>
                </a>
                <div class="submenu megamenu__text" id="shopby-brand">
                    <?php for ($i = 0; $i < count($camp_menu); $i++) { ?>
                        <div class="submenu__inner">
                            <a
                                href="<?php echo base_url() ?>camping/<?php echo str_replace(' ', '-', strtolower($camp_menu[$i]['camp_menu'])) ?>/<?php echo base64_encode($camp_menu[$i]['camp_menu_id']) ?>">
                                <h4 class="submenu__title">
                                    <?php echo $camp_menu[$i]['camp_menu'] ?>
                                </h4>
                            </a>

                            <?php for ($j = 0; $j < count($camp_submenu); $j++) {
                                if ($camp_submenu[$j]['camp_menuid'] === $camp_menu[$i]['camp_menu_id']) { ?>
                                    <ul class="submenu__list">
                                        <li><a
                                                href="<?php echo base_url() ?>camping-products/<?php echo strtolower(str_replace(' ', '-', $camp_submenu[$j]['c_submenu'])) ?>/<?php echo base64_encode($camp_submenu[$j]['c_submenu_id']) ?>/1">
                                                <?php echo $camp_submenu[$j]['c_submenu'] ?>
                                            </a>
                                        </li>
                                    </ul>
                                <?php }
                            } ?>

                        </div>
                        <?php
                    } ?>

                </div>
            </li>
            <li class="menu__item menu__dropdown" id="menu__item">
                <a class="menu__link">
                    SHOP BY BRANDS
                    <i class="bx bx-chevron-right"></i>
                </a>
                <div class="submenu megamenu__text" id="shopby-brand">
                    <?php for ($i = 0; $i < count($brand_master); $i++) {
                        ?>
                        <div class="submenu__inner">
                            <a
                                href="<?php echo base_url() ?>brands/<?php echo strtolower(str_replace(' ', '-', $brand_master[$i]['brand_name'])) ?>/<?php echo base64_encode($brand_master[$i]['brand_master_id']) ?>">
                                <div class="brand_names">
                                    <!-- <img src="<?php echo base_url() ?><?php echo $brand_master[$i]['brand_img'] ?>"
                                        width="25" height="25" /> -->
                                    <h4 class="submenu__title">
                                        <?php echo $brand_master[$i]['brand_name'] ?>
                                    </h4>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </li>

        </ul>
    </div>
</section>

<!-- MOBILE MENU -->
<section class="navbar__right d-lg-none d-sm-block d-md-none p-0">
    <div class="header-item item-right">
        <div id="switch">
            <?php session()->get('user_name'); ?>
            <?php if (session()->get('username') != ''): ?>
                <div class="demo-icon-wrap-s2">
                    <span aria-hidden="true" class="icon_profile m-0 p-0"></span> &nbsp;
                    <?php echo session()->get('username') ?>
                </div>
            <?php else: ?>
                <div class="demo-icon-wrap-s2">
                    <span aria-hidden="true" class="icon_profile m-0 p-0"></span><a id="login-headerr"
                        href="<?php echo base_url() ?>login"> &nbsp;Login</a>
                </div>
            <?php endif; ?>

            <div class="demo-icon-wrap-s2 m-0">
                <span aria-hidden="true" class="icon_cart_alt m-0"></span>
            </div>
            <!-- mobile menu trigger -->
            <div class="mobile-menu-trigger">
                <span></span>
            </div>

        </div>
    </div>
    <!-- <span class="switch__light"><i class="bx bx-sun"></i></span>
<span class="switch__dark"><i class="bx bx-moon"></i></span> -->
</section>
<script>
    const menu = document.querySelector(".menu");
    const menuInner = menu.querySelector(".menu__inner");
    const menuArrow = menu.querySelector(".menu__arrow");
    const menuTitle = menu.querySelector(".menu__title");
    const burger = document.querySelector(".burger");
    const overlay = document.querySelector(".overlay");
    const menuButton = document.getElementById('icon_close');
    const searchToggleButton = document.getElementById("searchToggle");
    const mobileSearchPanel = document.getElementById("mobileSearch");


    // Navbar Menu Toggle Function
    function toggleMenu() {
        menu.classList.toggle("is-active");
        overlay.classList.toggle("is-active");
    }

    function closeMenu() {
        menu.classList.remove("is-active");
        overlay.classList.remove("is-active");
    }

    function closeMobileSearch() {
        if (mobileSearchPanel) {
            mobileSearchPanel.classList.remove("active");
            const mobileSearchInput = mobileSearchPanel.querySelector('input[name="search_bar"]');
            if (mobileSearchInput) {
                mobileSearchInput.blur();
            }
        }
    }

    document.addEventListener('click', (event) => {
        if (menuButton && menuButton.contains(event.target)) {
            closeMenu();
        }
    });

    document.addEventListener("click", function (event) {
        const menuIsOpen = menu.classList.contains("is-active");
        const searchIsOpen = mobileSearchPanel && mobileSearchPanel.classList.contains("active");

        if (menuIsOpen) {
            const clickedInsideMenu = menu.contains(event.target);
            const clickedBurger = burger.contains(event.target);
            const clickedSearchToggle = searchToggleButton && searchToggleButton.contains(event.target);
            if (clickedSearchToggle) {
                closeMenu();
            } else if (!clickedInsideMenu && !clickedBurger) {
                event.preventDefault();
                event.stopPropagation();
                closeMenu();
                return;
            }
        }

        if (searchIsOpen) {
            const clickedInsideSearch = mobileSearchPanel.contains(event.target);
            const clickedSearchToggle = searchToggleButton && searchToggleButton.contains(event.target);
            const clickedBurger = burger.contains(event.target);
            if (clickedBurger) {
                closeMobileSearch();
            } else if (!clickedInsideSearch && !clickedSearchToggle) {
                event.preventDefault();
                event.stopPropagation();
                closeMobileSearch();
            }
        }
    }, true);
    // Show Mobile Submenu Function
    function showSubMenu(children) {
        subMenu = children.querySelector(".submenu");
        subMenu.classList.add("is-active");
        subMenu.style.animation = "slideLeft 0.35s ease forwards";
        const menuTitle = children.querySelector("i").parentNode.childNodes[0]
            .textContent;
        menu.querySelector(".menu__title").textContent = menuTitle;
        menu.querySelector(".menu__header").classList.add("is-active");
    }

    // Hide Mobile Submenu Function
    function hideSubMenu() {
        subMenu.style.animation = "slideRight 0.35s ease forwards";
        setTimeout(() => {
            subMenu.classList.remove("is-active");
        }, 300);

        menu.querySelector(".menu__title").textContent = "";
        menu.querySelector(".menu__header").classList.remove("is-active");
    }

    // Toggle Mobile Submenu Function
    function toggleSubMenu(e) {
        if (!menu.classList.contains("is-active")) {
            return;
        }
        if (e.target.closest(".menu__dropdown")) {
            const children = e.target.closest(".menu__dropdown");
            showSubMenu(children);
        }
    }

    // Fixed Navbar Menu on Window Resize
    window.addEventListener("resize", () => {
        if (window.innerWidth >= 768) {
            if (menu.classList.contains("is-active")) {
                toggleMenu();
            }
        }
    });

    // Dark and Light Mode with localStorage
    // (function () {
    //     let darkMode = localStorage.getItem("darkMode");
    //     const darkSwitch = document.getElementById("switch");

    //     // Enable and Disable Darkmode
    //     const enableDarkMode = () => {
    //         document.body.classList.add("darkmode");
    //         localStorage.setItem("darkMode", "enabled");
    //     };

    //     const disableDarkMode = () => {
    //         document.body.classList.remove("darkmode");
    //         localStorage.setItem("darkMode", null);
    //     };

    //     // User Already Enable Darkmodeg1
    //     if (darkMode === "enabled") {
    //         enableDarkMode();
    //     }

    //     // User Clicks the Darkmode Toggle
    //     darkSwitch.addEventListener("click", () => {
    //         darkMode = localStorage.getItem("darkMode");
    //         if (darkMode !== "enabled") {
    //             enableDarkMode();
    //         } else {
    //             disableDarkMode();
    //         }
    //     });
    //     // Initialize All Event Listeners
    burger.addEventListener("click", toggleMenu);
    overlay.addEventListener("click", toggleMenu);
    menuArrow.addEventListener("click", hideSubMenu);
    menuTitle.addEventListener("click", hideSubMenu);
    menuInner.addEventListener("click", toggleSubMenu);
    //     let suggestions = [
    //         "Channel", "CodingLab", "CodingNepal", "YouTube", "YouTuber", "YouTube Channel",
    //         "Blogger", "Bollywood", "Vlogger", "Vehicles", "Facebook", "Freelancer",
    //         "Facebook Page", "Designer", "Developer", "Web Designer", "Web Developer",
    //         "Login Form in HTML & CSS", "How to learn HTML & CSS", "How to learn JavaScript",
    //         "How to become Freelancer", "How to become Web Designer", "How to start Gaming Channel",
    //         "How to start YouTube Channel", "What does HTML stand for?", "What does CSS stand for?"
    //     ];

    //     const searchInput = document.querySelector(".searchInput");
    //     const input = searchInput.querySelector("input");
    //     const resultBox = searchInput.querySelector(".resultBox");

    //     input.onkeyup = (e) => {
    //         let userData = e.target.value;
    //         let emptyArray = [];
    //         if (userData) {
    //             emptyArray = suggestions.filter((data) => {
    //                 return data.toLowerCase().startsWith(userData.toLowerCase());
    //             });
    //             emptyArray = emptyArray.map((data) => {
    //                 return '<li>' + data + '</li>';
    //             });
    //             searchInput.classList.add("active");
    //             showSuggestions(emptyArray);
    //             let allList = resultBox.querySelectorAll("li");
    //             for (let i = 0; i < allList.length; i++) {
    //                 allList[i].setAttribute("onclick", "select(this)");
    //             }
    //         } else {
    //             searchInput.classList.remove("active");
    //         }
    //     }

    //     function showSuggestions(list) {
    //         let listData;
    //         if (!list.length) {
    //             userValue = input.value;
    //             listData = '<li>' + userValue + '</li>';
    //         } else {
    //             listData = list.join('');
    //         }
    // resultBox.innerHTML = listData;

    function select(element) {
        let selectData = element.textContent;
        input.value = selectData;
        searchInput.classList.remove("active");
    }
    // ();
</script>

<!-- K -->
<script>
    $(document).ready(function () {
        const searchToggle = $("#searchToggle");
        const mobileSearch = $("#mobileSearch");
        const navbarCollapse = $(".burger");
        const menu = $(".menu");
        const overlay = $(".overlay");
        const isIPhone = /iPhone/i.test(navigator.userAgent || "");

        function blurSearchInputForIPhone() {
            if (!isIPhone) {
                return;
            }
            const activeEl = document.activeElement;
            if (activeEl && activeEl.matches('input[name="search_bar"]')) {
                activeEl.blur();
            }
        }

        if (searchToggle.length && mobileSearch.length) {
            searchToggle.on("click", function (e) {
                e.preventDefault();
                e.stopPropagation();
                if (menu.hasClass("is-active")) {
                    menu.removeClass("is-active");
                    overlay.removeClass("is-active");
                }
                if (mobileSearch.hasClass("active")) {
                    blurSearchInputForIPhone();
                }
                mobileSearch.toggleClass("active");
            });
        }

        if (navbarCollapse.length && mobileSearch.length) {
            navbarCollapse.on("click", function () {
                mobileSearch.removeClass("active");
                blurSearchInputForIPhone();
            });
        }

        // iPhone-only: ensure suggestions render while typing and prevent iOS zoom on search input.
        if (isIPhone) {
            document.documentElement.classList.add("iphone-device");

            const iPhoneSearchInputs = document.querySelectorAll('input[name="search_bar"]');
            iPhoneSearchInputs.forEach(function (inputEl) {
                inputEl.style.fontSize = "16px";

                inputEl.addEventListener("input", function () {
                    fetchSuggestions(this);
                });

                inputEl.addEventListener("search", function () {
                    fetchSuggestions(this);
                });
            });
        }
    });
</script>
