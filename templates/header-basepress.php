<?php
/**
 * Custom BasePress header template using exact Zeever header
 */

// Add a DOCTYPE and open the HTML tags for proper structure
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Directly insert Zeever header code -->
<!-- wp:group {"align":"full","className":"modern-header-wrapper","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull modern-header-wrapper"><!-- wp:cover {"url":"https://jotun.games/wp-content/uploads/2024/02/jotunheim-1-30reduced.png","id":150331,"dimRatio":50,"overlayColor":"black","isUserOverlayColor":true,"minHeight":50,"contentPosition":"center center","align":"full","className":"header-banner","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","right":"var:preset|spacing|30","bottom":"var:preset|spacing|30","left":"var:preset|spacing|30"}},"color":{"duotone":"unset"}},"layout":{"type":"default"}} -->
  <div class="wp-block-cover alignfull header-banner" style="padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30);min-height:50px"><img class="wp-block-cover__image-background wp-image-150331" alt="" src="https://jotun.games/wp-content/uploads/2024/02/jotunheim-1-30reduced.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-black-background-color has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:spacer {"height":"83px","className":"banner-spacer"} -->
  <div style="height:83px" aria-hidden="true" class="wp-block-spacer banner-spacer"></div>
  <!-- /wp:spacer -->
  
  <!-- wp:site-logo {"width":232,"shouldSyncIcon":true,"align":"left","className":"is-style-default site-logo"} /-->
  
  <!-- wp:spacer {"height":"84px","className":"banner-spacer"} -->
  <div style="height:84px" aria-hidden="true" class="wp-block-spacer banner-spacer"></div>
  <!-- /wp:spacer -->
  
  <!-- wp:group {"className":"navigation-wrapper","layout":{"type":"flex","orientation":"vertical","justifyContent":"center","verticalAlignment":"bottom"}} -->
  <div class="wp-block-group navigation-wrapper"><!-- wp:spacer {"height":"185px","width":"0px","className":"banner-spacer","style":{"layout":{"flexSize":"0px","selfStretch":"fixed"},"spacing":{"margin":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}}} -->
  <div style="margin-top:var(--wp--preset--spacing--80);margin-bottom:var(--wp--preset--spacing--80);height:185px;width:0px" aria-hidden="true" class="wp-block-spacer banner-spacer"></div>
  <!-- /wp:spacer -->
  
  <!-- wp:gutenverse/nav-menu {"elementId":"guten-PejLCt","menuId":7,"alignment":{"Desktop":"center","Tablet":"flex-start","Mobile":"flex-start"},"mobileMenuLogo":{"media":{"imageId":74,"sizes":{"full":{"url":"https://jotun.games/wp-content/uploads/2023/07/untitled-design-23.png","height":250,"width":250,"orientation":"landscape"}}},"size":"full"},"mobileLogoWidth":{"Desktop":""},"mobileLogoFit":{"Desktop":"scale-down"},"mobileMenuMargin":{"Desktop":[],"desktop":[]},"mobileMenuPadding":{"Desktop":[],"desktop":[]},"menuHeight":{"Desktop":""},"mobileWrapperBackground":{"Tablet":{"r":11,"g":12,"b":16,"a":1}},"menuPadding":{"Desktop":[],"Tablet":{"unit":"px","dimension":{"left":"20","right":"20","top":"20"}},"desktop":[]},"menuMargin":{"Desktop":[],"Tablet":[],"desktop":[]},"menuRadius":{"Desktop":[],"desktop":[]},"itemTypography":{"type":"variable","id":"nav-font"},"itemSpacing":{"Desktop":{"unit":"px","dimension":{"left":"30","top":"","right":"","bottom":""}},"Tablet":{"unit":"px","dimension":{"left":"10","right":"","bottom":""}},"Mobile":[]},"itemTextNormalColor":{"Desktop":{"type":"variable","id":"zeever-primary"},"Tablet":{"r":255,"g":255,"b":255,"a":1}},"itemTextHoverColor":{"Desktop":{"type":"variable","id":"zeever-secondary"},"Tablet":{"r":102,"g":252,"b":241,"a":1}},"itemTextActiveColor":{"Desktop":{"type":"variable","id":"zeever-secondary"},"Tablet":{"r":102,"g":252,"b":241,"a":1}},"submenuItemIndicator":"fas fa-chevron-down","submenuIndicatorColor":{"Tablet":[],"Desktop":[]},"submenuIndicatorActiveColor":{"Tablet":[]},"submenuIndicatorMargin":{"Desktop":[],"Tablet":{"unit":"px","dimension":{"left":"","right":"20","top":"","bottom":""}},"Mobile":[]},"submenuIndicatorPadding":{"Desktop":[],"Tablet":{"unit":"px","dimension":{"top":"10","right":"10","bottom":"10","left":"10"}},"Mobile":[]},"submenuIndicatorBorder":{"radius":{"Tablet":[],"Desktop":[]},"all":{"type":"none"}},"submenuTypography":{"type":"variable","id":"nav-font"},"submenuSpacing":{"Desktop":[],"Tablet":[]},"submenuTextNormalColor":{"Desktop":{"type":"variable","id":"zeever-third"},"Tablet":{"r":255,"g":255,"b":255,"a":1}},"submenuTextNormalBg":{"type":"default","color":""},"submenuTextHoverColor":{"Desktop":{"type":"variable","id":"zeever-secondary"},"Tablet":{"r":102,"g":252,"b":241,"a":1}},"submenuTextActiveColor":{"Desktop":{"type":"variable","id":"zeever-secondary"},"Tablet":{"r":102,"g":252,"b":241,"a":1}},"submenuTextActiveBg":{"type":"default","color":""},"submenuItemBorder":{"radius":{"Tablet":[],"Desktop":[]}},"submenuFirstItemBorder":{"radius":{"Desktop":[],"Tablet":[]}},"submenuLastItemBorder":{"radius":{"Desktop":[],"Tablet":[]}},"submenuPanelPadding":{"Desktop":[],"Tablet":[],"desktop":[]},"submenuPanelBorder":{"radius":{"Desktop":[],"Tablet":[],"desktop":[]}},"submenuPanelWidth":{"Desktop":"337"},"hamburgerPadding":{"Tablet":{"unit":"px","dimension":{"top":"15","right":"20","bottom":"15","left":"20"}},"Mobile":{"unit":"px","dimension":{"bottom":"10","top":"10","right":"15","left":"15"}},"Desktop":[]},"hamburgerMargin":{"Tablet":[],"Mobile":{"unit":"px","dimension":{"top":"10"}},"Desktop":[]},"hamburgerColorNormal":{"Tablet":{"r":255,"g":255,"b":255,"a":1}},"hamburgerBgNormal":{"type":"default","color":{"r":255,"g":255,"b":255,"a":0}},"hamburgerBorderNormal":{"radius":{"Tablet":[],"Mobile":[],"Desktop":[]},"all":{"type":"solid","width":"2","color":""}},"hamburgerBorderHover":{"radius":{"Desktop":[]}},"closePadding":{"Tablet":{"unit":"px","dimension":{"top":"10","bottom":"10"}},"Mobile":[],"Desktop":[]},"closeMargin":{"Tablet":[],"Mobile":[],"Desktop":[]},"closeColorNormal":{"Tablet":{"r":255,"g":255,"b":255,"a":1}},"closeBgNormal":{"type":"default","color":{"r":255,"g":255,"b":255,"a":0}},"closeBorderNormal":{"radius":{"Tablet":{"unit":"px","dimension":{"top":"0","right":"0","bottom":"0","left":"0"}},"Mobile":[],"Desktop":[]},"all":{"type":"solid","width":"1","color":{"type":"variable","id":"zeever-secondary"}}},"closeBorderHover":{"radius":{"Desktop":[]}},"border":{"radius":{"Tablet":[],"Desktop":[],"desktop":[]}},"margin":{"Desktop":{"unit":"px","dimension":{"top":"-150","right":"","bottom":"","left":""}},"desktop":[]},"padding":{"Desktop":{"unit":"px","dimension":{"top":"","right":"","bottom":"","left":""}},"desktop":[]},"hideDesktop":false,"hideTablet":false,"hideMobile":false,"positioningType":{"Desktop":"default"},"positioningAlign":{"Desktop":"center"},"positioningLocation":"default"} -->
  <div class="guten-element guten-nav-menu guten-PejLCt"></div>
  <!-- /wp:gutenverse/nav-menu --></div>
  <!-- /wp:group --></div></div>
  <!-- /wp:cover -->
  
  <!-- wp:gutenverse/divider {"elementId":"guten-VLbNyj","dividerColor":{"type":"variable","id":"zeever-secondary"},"background":{"type":"default","color":""},"border":{"radius":{"Desktop":[]}},"margin":{"Desktop":{"unit":"px","dimension":{"top":"","right":"","bottom":"","left":""}}},"padding":{"Desktop":{"unit":"px","dimension":{"top":"","right":"","bottom":"","left":""}}},"positioningType":{"Desktop":"default"},"positioningWidth":{"Desktop":{"point":"345","unit":"px"}}} -->
  <div class="wp-block-gutenverse-divider guten-element guten-divider guten-VLbNyj"><div class="guten-divider-wrapper"><div class="guten-divider-default guten-divider-line guten-divider-regular"></div></div></div>
  <!-- /wp:gutenverse/divider -->
  
  <!-- wp:html -->
  <style>
            /* Modern Header Styles */
            .modern-header-wrapper {
              /* background-color: rgba(11, 12, 16, 1); --- Removed background color */
            }
  
            .wp-block-cover.header-banner {
              position: fixed !important;
              top: 0;
              left: 0;
              right: 0;
              max-width: 2400px; /* Updated max-width */
              margin-left: auto; /* Added for centering */
              margin-right: auto; /* Added for centering */
              z-index: 99990 !important; /* Increased z-index significantly */
              height: auto;
              background-size: cover;
              transition: top 0.2s ease-out !important; /* Added for smoother scrolling */
            }
            
            /* Move ONLY the navigation down by 15px - more specific selector */
            .wp-block-group.navigation-wrapper {
              position: relative;
              top: 15px !important;
            }
            
            /* Position nav bar 10px from top when scrolled */
            .header-scrolled .wp-block-group.navigation-wrapper {
              top: 20px !important;
            }
  
            /* Small logo styling for scrolled header - bottom left corner */
            .small-header-logo {
              display: none;
              position: absolute;
              left: 20px;
              bottom: 15px;
              height: 40px;
              width: auto;
              z-index: 999999 !important;
              opacity: 0;
              transition: opacity 0.3s ease;
              pointer-events: none; /* Prevent logo from intercepting clicks */
              filter: drop-shadow(0 0 3px rgba(0,0,0,0.5)); /* Add shadow for visibility */
            }
            
            /* Show logo when scrolled */
            .header-scrolled .small-header-logo {
              display: block !important;
              opacity: 1 !important;
            }
            
            /* Jotunheim title styling - only visible when scrolled */
            .jotunheim-title {
              position: absolute;
              left: 50%;
              bottom: 25px; /* Updated from 15px to 25px */
              transform: translateX(-50%);
              font-family: 'Norse', 'Cinzel Decorative', 'Times New Roman', serif;
              font-size: 25px; /* Updated from 15px to 25px */
              font-weight: 700;
              color: #9e9e9e;
              letter-spacing: 5px; /* Increased letter spacing to match image */
              text-transform: uppercase;
              text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
              z-index: 999999;
              margin: 0;
              padding: 0;
              opacity: 0; /* Hidden by default */
              visibility: hidden; /* Hidden by default */
              transition: opacity 0.3s ease, visibility 0.3s ease; /* Smooth transition */
            }
            
            /* Add Norse font */
            @font-face {
              font-family: 'Norse';
              src: url('https://jotun.games/wp-content/uploads/fonts/Norse.woff2') format('woff2'),
                   url('https://jotun.games/wp-content/uploads/fonts/Norse.woff') format('woff');
              font-weight: normal;
              font-style: normal;
              font-display: swap;
            }
            
            /* Show title only when scrolled */
            .header-scrolled .jotunheim-title {
              opacity: 1; /* Show when scrolled */
              visibility: visible; /* Show when scrolled */
            }
            
            /* Include web font */
            @import url('https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&display=swap');
            
            /* Fix dropdown menus getting cut off - Desktop Only */
            @media (min-width: 769px) { /* Apply only on screens wider than 768px */
              .guten-element.guten-nav-menu {
                position: relative;
                z-index: 200; /* Higher z-index to ensure dropdowns appear above other elements */
                overflow: visible !important; /* Allow dropdowns to overflow */
              }
  
              .guten-element.guten-nav-menu ul.sub-menu,
              .guten-element.guten-nav-menu .guten-dropdown {
                position: absolute !important;
                top: 100% !important; /* Position below the parent */
                left: 0; /* Align with the left edge of the parent */
                z-index: 9999 !important;
                min-width: 180px;
                overflow: visible !important;
              }
  
              .navigation-wrapper,
              .wp-block-cover.header-banner {
                overflow: visible !important;
              }
  
              .guten-element.guten-nav-menu li.menu-item-has-children {
                position: relative !important; /* Needed for absolute positioning of submenu */
              }
  
              /* Fix gap between header banner and divider */
              .header-placeholder + .wp-block-gutenverse-divider.guten-VLbNyj {
                margin-top: -50px !important; /* Increased negative margin */
              }
            }
  
            /* Tablet Mode Submenu Fix */
            @media (min-width: 768px) and (max-width: 1023px) { /* Specific range */
              /* Ensure parent list items can contain static submenus */
              .guten-element.guten-nav-menu li.menu-item-has-children { /* Be more specific */
                position: relative !important; /* Ensure context */
                height: auto !important; /* Allow height to grow */
                overflow: visible !important; /* Ensure submenu isn't clipped */
              }
  
              /* Reset submenu positioning and ensure it flows statically */
              .guten-element.guten-nav-menu ul.sub-menu,
              .guten-element.guten-nav-menu .guten-dropdown {
                position: static !important; /* Force static positioning */
                display: none; /* Initially hidden - let JS control visibility */
                width: 100% !important; /* Take full width */
                height: auto !important; /* Auto height */
                box-shadow: none !important;
                background-color: transparent !important;
                border: none !important;
                padding-left: 15px !important; /* Indent */
                margin: 0 !important; /* Reset margins */
                float: none !important; /* Prevent floating */
                overflow: visible !important;
              }
  
              /* Style for when the submenu is likely made visible by JS */
              /* This targets common patterns; might need adjustment based on the plugin's actual behavior */
              .guten-element.guten-nav-menu li.menu-item-has-children.open > ul.sub-menu,
              .guten-element.guten-nav-menu li.menu-item-has-children.is-open > ul.sub-menu,
              .guten-element.guten-nav-menu li.menu-item-has-children.current-menu-ancestor > ul.sub-menu, /* Added for active page ancestor */
              .guten-element.guten-nav-menu li.menu-item-has-children:focus-within > ul.sub-menu {
                display: block !important; /* Make visible when parent is 'open' or interacted with */
              }
  
              /* Style submenu links */
               .guten-element.guten-nav-menu ul.sub-menu li a {
                  padding: 8px 15px 8px 0 !important;
                  display: block !important;
                  width: 100% !important; /* Ensure link takes full width */
               }
  
               /* Ensure the main mobile container styles are still applied */
               .guten-nav-menu-mobile-container {
                 z-index: 100000 !important;
                 position: fixed !important;
                 top: 0 !important; /* Align to viewport top */
                 left: 0 !important; /* Align to viewport left */
                 width: 100% !important; /* Cover full width */
                 height: 100% !important; /* Cover full height */
                 background-color: rgba(11, 12, 16, 0.95) !important; /* Ensure visible background */
                 overflow-y: auto !important; /* Allow scrolling within the menu */
               }
            }
  
            /* Hide logo on medium screens */
            @media (max-width: 1600px) { /* Updated breakpoint */
              .site-logo {
                visibility: hidden !important;
                opacity: 0 !important;
                pointer-events: none !important; /* Prevent interactions */
                display: block !important; /* Ensure it still takes up block space */
              }
            }
  
            /* Mobile-specific styles */
            @media (max-width: 768px) { /* Adjust breakpoint as needed */
              /* Hide spacers */
              .banner-spacer {
                display: none !important;
              }
  
              /* Hide the JS placeholder on mobile as the relative header occupies space */
              .header-placeholder {
                display: none !important;
              }
  
              /* Adjust banner padding and height, and reset position/z-index */
              .wp-block-cover.header-banner {
                  padding-top: var(--wp--preset--spacing--20) !important;
                  padding-bottom: var(--wp--preset--spacing--20) !important;
                  padding-left: var(--wp--preset--spacing--20) !important;
                  padding-right: var(--wp--preset--spacing--20) !important;
                  min-height: 250px !important; /* Increased min-height significantly */
                  background-size: cover !important; /* Revert to cover */
                  background-position: center center !important; /* Center image */
                  position: relative !important; /* Override fixed position for mobile */
                  z-index: auto !important; /* Reset z-index for mobile */
                  max-width: none; /* Override max-width for mobile */
                  margin-left: 0; /* Override margin for mobile */
                  margin-right: 0; /* Override margin for mobile */
              }
  
              /* Reset inner container styles */
              .wp-block-cover__inner-container {
                  width: 100%;
                  /* Removed display:flex, flex-direction, align-items, justify-content */
                  min-height: inherit;
              }
  
              /* Adjust navigation wrapper positioning and ensure visibility */
              .navigation-wrapper {
                  margin-top: 0 !important;
                  width: 100% !important; /* Ensure full width */
                  height: auto !important; /* Ensure height isn't collapsed */
                  display: block !important; /* Treat as block element */
                  position: relative;
                  z-index: 210; /* Ensure wrapper is above banner */
                  visibility: visible !important;
                  opacity: 1 !important;
                  /* Removed flex-grow */
              }
  
              /* Ensure the Gutenverse nav menu block is visible and reset margin */
              .guten-element.guten-nav-menu {
                  display: block !important; /* Treat as block element */
                  width: 100% !important;
                  height: auto !important; /* Ensure height isn't collapsed */
                  visibility: visible !important;
                  opacity: 1 !important;
                  margin-top: 0 !important; /* Override negative desktop margin */
                  z-index: 99999 !important; /* Ensure menu itself is above page content - Increased */
                  position: relative; /* Needed for z-index to apply reliably */
              }
  
              /* Ensure the opened mobile menu container is above everything */
              .guten-nav-menu-mobile-container { /* Adjust class if needed */
                z-index: 100000 !important;
                position: fixed !important;
                top: 0 !important; /* Align to viewport top */
                left: 0 !important; /* Align to viewport left */
                width: 100% !important; /* Cover full width */
                height: 100% !important; /* Cover full height */
                background-color: rgba(11, 12, 16, 0.95) !important; /* Ensure visible background */
                overflow-y: auto !important; /* Allow scrolling within the menu */
              }
  
              /* Fix submenu stacking in mobile/tablet menu */
              .guten-element.guten-nav-menu ul.sub-menu,
              .guten-element.guten-nav-menu .guten-dropdown {
                position: static !important;
                width: auto !important;
                box-shadow: none !important;
                background-color: transparent !important;
                border: none !important;
                padding-left: 15px !important; /* Indent submenus */
                margin-left: 0; /* Reset any potential margin */
              }
  
              /* Ensure list items flow correctly */
              .guten-element.guten-nav-menu li {
                display: block;
                width: 100%;
              }
            }

            /* Discord join button styling */
            .discord-join-button {
              position: absolute;
              right: 20px;
              bottom: -10px;
              transform: translateY(-50%);
              background-color: #7289DA; /* Discord color */
              color: white;
              padding: 8px 16px;
              border-radius: 4px;
              font-family: 'Norse', 'Cinzel Decorative', sans-serif;
              font-size: 14px;
              text-decoration: none;
              display: flex;
              align-items: center;
              transition: all 0.3s ease;
              z-index: 999999;
              box-shadow: 0 2px 4px rgba(0,0,0,0.2);
              opacity: 0; /* Hidden by default */
              visibility: hidden; /* Hidden by default */
            }
            
            /* Only show button in scrolled state */
            .header-scrolled .discord-join-button {
              opacity: 1; /* Show when scrolled */
              visibility: visible; /* Show when scrolled */
            }
            
            /* BasePress specific styles */
            .bpress-header {
              display: none !important;
            }
            
            /* Adjust spacing for KB content */
            .kb-content-wrapper {
              margin-top: 250px; /* Add space below the header */
              max-width: 1200px; 
              margin-left: auto;
              margin-right: auto;
              padding: 20px;
            }
        </style>
            
        <script>
        document.addEventListener('DOMContentLoaded', function() {
          const mainHeader = document.querySelector('.wp-block-cover.header-banner');
          if (!mainHeader) return;
          
          // Add the logo to the header
          const smallLogo = document.createElement('img');
          smallLogo.src = "https://jotun.games/wp-content/uploads/2023/07/untitled-design-23.png";
          smallLogo.alt = "Jotun Games";
          smallLogo.className = "small-header-logo";
          mainHeader.appendChild(smallLogo);
          
          // Add the Jotunheim title to the header
          const jotunheimTitle = document.createElement('div');
          jotunheimTitle.className = 'jotunheim-title';
          jotunheimTitle.textContent = 'JOTUNHEIM';
          mainHeader.appendChild(jotunheimTitle);
          
          // Add Discord join button
          const discordButton = document.createElement('a');
          discordButton.href = 'https://discord.com/invite/jotunvalheim';
          discordButton.className = 'discord-join-button';
          discordButton.target = '_blank'; // Open in new tab
          discordButton.rel = 'noopener noreferrer'; // Security best practice
          
          // Add Discord icon
          discordButton.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" fill="currentColor">
              <path d="M524.531,69.836a1.5,1.5,0,0,0-.764-.7A485.065,485.065,0,0,0,404.081,32.03a1.816,1.816,0,0,0-1.923.91,337.461,337.461,0,0,0-14.9,30.6,447.848,447.848,0,0,0-134.426,0,309.541,309.541,0,0,0-15.135-30.6,1.89,1.89,0,0,0-1.924-.91A483.689,483.689,0,0,0,116.085,69.137a1.712,1.712,0,0,0-.788.676C39.068,183.651,18.186,294.69,28.43,404.354a2.016,2.016,0,0,0,.765,1.375A487.666,487.666,0,0,0,176.02,479.918a1.9,1.9,0,0,0,2.063-.676A348.2,348.2,0,0,0,208.12,430.4a1.86,1.86,0,0,0-1.019-2.588,321.173,321.173,0,0,1-45.868-21.853,1.885,1.885,0,0,1-.185-3.126c3.082-2.309,6.166-4.711,9.109-7.137a1.819,1.819,0,0,1,1.9-.256c96.229,43.917,200.41,43.917,295.5,0a1.812,1.812,0,0,1,1.924.233c2.944,2.426,6.027,4.851,9.132,7.16a1.884,1.884,0,0,1-.162,3.126,301.407,301.407,0,0,1-45.89,21.83,1.875,1.875,0,0,0-1,2.611,391.055,391.055,0,0,0,30.014,48.815,1.864,1.864,0,0,0,2.063.7A486.048,486.048,0,0,0,610.7,405.729a1.882,1.882,0,0,0,.765-1.352C623.729,277.594,590.933,167.465,524.531,69.836ZM222.491,337.58c-28.972,0-52.844-26.587-52.844-59.239S193.056,219.1,222.491,219.1c29.665,0,53.306,26.82,52.843,59.239C275.334,310.993,251.924,337.58,222.491,337.58Zm195.38,0c-28.971,0-52.843-26.587-52.843-59.239S388.437,219.1,417.871,219.1c29.667,0,53.307,26.82,52.844,59.239C470.715,310.993,447.538,337.58,417.871,337.58Z"/>
            </svg>
            JOIN
          `;
          
          mainHeader.appendChild(discordButton);
    
          // Set initial position based on screen width
          if (window.innerWidth > 768) {
            // Desktop - move header up by 30px
            mainHeader.style.top = '-30px';
          } else {
            // Mobile - keep header at top of viewport
            mainHeader.style.top = '0px';
          }
    
          // Create a placeholder to prevent layout jump for the initial space
          let placeholder = document.createElement('div');
          placeholder.className = 'header-placeholder';
          placeholder.style.marginTop = '-30px'; // Negative margin to pull content up
          
          // Insert placeholder *after* the header in the DOM
          if (mainHeader.nextSibling) {
            mainHeader.parentNode.insertBefore(placeholder, mainHeader.nextSibling);
          } else {
            mainHeader.parentNode.appendChild(placeholder);
          }
    
          let headerHeight = 0;
          let maxScrollOffset = 0;
          const visibleHeight = 90; // Desired visible height when scrolled
    
          // Variables for throttling scroll events
          let lastScrollTime = 0;
          let scrollTimeout = null;
          const scrollThrottle = 10; // Only process scroll events every 10ms
    
          // Function to update header dimensions and calculate max offset
          function updateHeaderDimensions() {
            // Ensure header is visible for height calculation if it was moved up
            const currentTop = mainHeader.style.top;
            mainHeader.style.top = '-15px'; // Changed from 0px to -15px
            headerHeight = mainHeader.offsetHeight;
            mainHeader.style.top = currentTop; // Restore original top
    
            maxScrollOffset = headerHeight - visibleHeight;
            if (maxScrollOffset < 0) {
              maxScrollOffset = 0; // Ensure offset isn't negative if header is already small
            }
            // Call handleScroll immediately to set the correct initial placeholder height based on scroll position
            handleScroll();
          }
    
          // Function to handle scroll events with throttling
          function handleScroll() {
            // Throttle scroll events
            const now = performance.now();
            if (now - lastScrollTime < scrollThrottle) {
              // If we're throttling, schedule a single deferred update
              if (!scrollTimeout) {
                scrollTimeout = setTimeout(() => {
                  updateHeaderPosition();
                  scrollTimeout = null;
                  lastScrollTime = performance.now();
                }, scrollThrottle);
              }
              return;
            }
            
            lastScrollTime = now;
            updateHeaderPosition();
          }
          
          // Separated the actual header position update logic
          function updateHeaderPosition() {
            requestAnimationFrame(() => {
              const scrollY = window.scrollY;
              let newTop = -30; // Starting position is -15px instead of 0
              let visibleHeaderHeight = headerHeight;
              
              // Add or remove the header-scrolled class based on scroll position
              if (scrollY <= maxScrollOffset) {
                newTop = -30 - scrollY; // Start from -15px position
                visibleHeaderHeight = headerHeight - scrollY;
                mainHeader.classList.remove('header-scrolled');
              } else {
                newTop = -30 - maxScrollOffset; // Start from -15px position
                visibleHeaderHeight = visibleHeight;
                mainHeader.classList.add('header-scrolled'); // Add class when scrolled
              }
              
              // Ensure visible height isn't negative
              visibleHeaderHeight = Math.max(visibleHeaderHeight, 0);
              
              // Apply the calculated top value to the header
              if (mainHeader.style.top !== newTop + 'px') {
                mainHeader.style.top = newTop + 'px';
              }
              
              // Update placeholder height based on the visible part of the header
              if (placeholder.style.height !== visibleHeaderHeight + 'px') {
                placeholder.style.height = visibleHeaderHeight + 'px';
              }
            });
          }
    
          // Cleanup function to prevent memory leaks
          function cleanup() {
            window.removeEventListener('resize', updateHeaderDimensions);
            window.removeEventListener('scroll', handleScroll);
            if (scrollTimeout) {
              clearTimeout(scrollTimeout);
            }
          }
    
          // Initial setup on DOMContentLoaded
          updateHeaderDimensions();
    
          // Refine dimensions after all resources (like images) are loaded
          window.addEventListener('load', updateHeaderDimensions);
    
          // Add event listeners with cleanup
          window.addEventListener('resize', updateHeaderDimensions);
          window.addEventListener('scroll', handleScroll);
          
          // Clean up event listeners when page is left
          window.addEventListener('beforeunload', cleanup);
        });
        </script>
  <!-- /wp:html --></div>
  <!-- /wp:group -->

<!-- Add wrapper for KB content -->
<div class="kb-content-wrapper">
<?php