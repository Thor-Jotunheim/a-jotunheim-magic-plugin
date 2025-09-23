# Jotunheim Shop Manager - Product Requirements Document

Create a comprehensive shop management system for the Jotunheim gaming community to replace Google Sheets-based transaction tracking, player registration, and inventory management with Discord OAuth authentication.

**Experience Qualities**: 
1. **Efficient** - Streamlined workflows that reduce administrative overhead compared to complex spreadsheet operations
2. **Reliable** - Persistent data storage with clear transaction validation and error handling
3. **Secure** - Discord-based authentication with role-based access control through jotun.games backend integration

**Complexity Level**: 
- Complex Application (advanced functionality, accounts, authentication)
- This system handles multiple interconnected data types (players, transactions, items, ledgers) with role-based access, Discord OAuth integration, and complex business logic for legacy item management and world resets.

## Essential Features

**Discord Authentication System**
- Functionality: Secure login through Discord OAuth via jotun.games backend
- Purpose: Ensure only authorized community members can access shop management tools
- Trigger: User clicks "Login with Discord" button
- Progression: Redirect to Discord → authorize application → return with user data → validate roles → grant appropriate permissions
- Success criteria: User logged in with correct role-based permissions displayed

**Role-Based Access Control**
- Functionality: Different permission levels based on Discord server roles
- Purpose: Ensure users only access features appropriate to their responsibilities
- Trigger: User authentication completion
- Progression: Retrieve Discord roles → map to application permissions → show/hide interface elements
- Success criteria: Interface adapts to user's permission level (Norn/Aesir/Staff/Chosen)

**Player Registration System**
- Functionality: Add new players to registry with duplicate checking
- Purpose: Maintain centralized player database across all shop types
- Trigger: Staff enters player name in registration form
- Progression: Enter name → validate uniqueness → confirm registration → success notification
- Success criteria: Player appears in registry and can be selected for transactions

**Transaction Recording (Multi-Shop)**
- Functionality: Record purchases/sales across Admin, Popup, Haldore, and Beehive shops
- Purpose: Track all economic activity with proper validation and archival
- Trigger: Staff completes transaction form with player and items
- Progression: Select player → enter items/quantities → validate transaction → record to ledger → clear form
- Success criteria: Transaction appears in both active and archive ledgers

**Item Management System**
- Functionality: Display current item database with pricing and availability
- Purpose: Provide reference for transaction recording and price consistency
- Trigger: User navigates to item list or searches for specific items
- Progression: Browse/search items → view details → use in transactions
- Success criteria: Items display with correct pricing and can be selected for transactions

**Player Rename Functionality**
- Functionality: Update player names across all systems and historical data
- Purpose: Maintain data integrity when players change names
- Trigger: Admin initiates rename with old and new names
- Progression: Enter names → validate existence → confirm action → update all records → log change
- Success criteria: All instances of old name replaced, change logged in history

**Ledger Management**
- Functionality: Clear/archive ledgers and handle world resets with legacy item tracking
- Purpose: Manage periodic data archival and special game mechanics
- Trigger: Admin initiates ledger clear or world reset
- Progression: Select operation → confirm action → process data transfer → update legacy items → notify completion
- Success criteria: Data properly archived, legacy items tracked correctly

## Edge Case Handling

- **Duplicate Player Registration**: Check registry before adding, display clear error message
- **Invalid Transaction Data**: Validate all fields before recording, show specific validation errors
- **Network/API Failures**: Graceful error handling with retry options and offline indication
- **Concurrent Access**: Handle multiple users editing same data with conflict resolution
- **Data Corruption Recovery**: Backup mechanisms and data validation checks

## Design Direction

The design should feel professional and reliable like enterprise software, emphasizing data integrity and operational efficiency over visual flair, with a clean minimal interface that prioritizes functionality and reduces cognitive load during high-frequency administrative tasks.

## Color Selection

Triadic color scheme using blue, amber, and green to represent different operational states and shop types while maintaining professional appearance.

- **Primary Color**: Deep Blue (oklch(0.45 0.15 240)) - Communicates trust and stability for core actions
- **Secondary Colors**: Slate Gray (oklch(0.35 0.02 240)) for backgrounds and Steel Blue (oklch(0.55 0.12 240)) for secondary actions
- **Accent Color**: Amber (oklch(0.75 0.15 60)) - Attention-grabbing highlight for important actions and warnings
- **Foreground/Background Pairings**: 
  - Background (White oklch(0.98 0.01 240)): Dark Blue text (oklch(0.25 0.05 240)) - Ratio 8.2:1 ✓
  - Primary (Deep Blue oklch(0.45 0.15 240)): White text (oklch(0.98 0.01 240)) - Ratio 6.8:1 ✓
  - Secondary (Slate Gray oklch(0.35 0.02 240)): White text (oklch(0.98 0.01 240)) - Ratio 9.1:1 ✓
  - Accent (Amber oklch(0.75 0.15 60)): Dark Blue text (oklch(0.25 0.05 240)) - Ratio 7.4:1 ✓

## Font Selection

Clean, readable sans-serif typography that conveys professionalism and ensures excellent legibility during data entry tasks, using Inter for its exceptional clarity at all sizes.

- **Typographic Hierarchy**: 
  - H1 (Page Titles): Inter Bold/32px/tight letter spacing
  - H2 (Section Headers): Inter SemiBold/24px/normal spacing  
  - H3 (Subsections): Inter Medium/18px/normal spacing
  - Body Text: Inter Regular/16px/relaxed spacing
  - Small Text: Inter Regular/14px/normal spacing

## Animations

Subtle and functional animations that provide immediate feedback without interfering with rapid data entry workflows, focusing on state transitions and form validation.

- **Purposeful Meaning**: Quick micro-interactions communicate system responsiveness and guide attention to important state changes
- **Hierarchy of Movement**: Form validation gets immediate animation priority, followed by navigation transitions, with decorative elements minimized

## Component Selection

- **Components**: 
  - Forms: Input, Select, Button components with validation states
  - Data Display: Table, Card for transaction lists and player information
  - Navigation: Tabs for different shop types and functions
  - Dialogs: AlertDialog for confirmations, Dialog for complex forms
  - Feedback: Toast notifications for success/error states
- **Customizations**: Transaction summary cards, item selection dropdowns with search, ledger data tables with sorting
- **States**: Clear hover/focus states for all interactive elements, loading states for data operations, error states with recovery options
- **Icon Selection**: Plus for add actions, Check for confirmations, X for cancellations, Search for lookups
- **Spacing**: Consistent 16px base spacing with 8px for tight areas and 24px for section separation
- **Mobile**: Stacked forms on mobile, collapsible navigation, responsive tables with horizontal scroll

## Bugs/Problems 
- ✅ **RESOLVED** - In Dashboard Manager search, Shop Manager[shop_manager] & Unified Teller[unified_teller] pages do not show up when searching. Enhance the add pages search to ensure any new pages made can be found. If the problem is these are short codes and no page for it currently exists, i want the search function to be able to handle those and create a page in the dashboard for them if selected. 
  - **Solution**: Enhanced `get_available_plugin_pages()` to detect shortcode-based pages, added `add_shortcode_pages()` method, created automatic WordPress page creation for shortcodes, and updated JavaScript workflow.
- ✅ **RESOLVED** - Overview page of the Dashboard links to pages do not work. I get an error about not having permissions.
  - **Solution**: Fixed overview page links to use `item['slug']` instead of `item['id']` for proper WordPress admin page routing and permission checking. 

## Spark Integration
- I started using Spark to create an app, but i realized it wasn't going to work with my website plugin well, so i decided to bring what was made over there, to here in this magic plugin. Here is the git, if you can review it, maybe we can use some of it over here to save us time and energy. https://github.com/Thor-Jotunheim/jotunheim-admin-dash.git. Alternativly, i can drag and drop all these files into this same project folder so you have access to those files. . or i can just give you the local files location. 