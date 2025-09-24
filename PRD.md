# Jotunheim Shop Manager - Product Requirements Document

Create a comprehensive shop management system for the Jotunheim gaming community to replace Google Sheets-based transaction tracking, player registration, and inventory management with Discord OAuth authentication.

**Experience Qualities**: 
1. **Efficient** - Streamlined workflows that reduce administrative overhead compared to complex spreadsheet operations
2. **Reliable** - Persistent data storage with clear transaction validation and error handling
3. **Secure** - Discord-based authentication with role-based access control through jotun.games backend integration

**Complexity Level**: 
- Complex Application (advanced functionality, accounts, authentication)
- This system handles multiple interconnected data types (players, transactions, items, ledgers) with role-based access, Discord OAuth integration, and complex business logic for legacy item management and world resets.

## Implementation Status

### ✅ **COMPLETED FEATURES**

**Player List Management System**
- Functionality: Complete player registration and management with duplicate checking
- Implementation: Full CRUD operations with database storage and validation
- Features: Add/edit/delete players, search functionality, bulk operations
- Access: Role-based permissions (Admin/Staff access required)

**Discord Authentication System**
- Functionality: Secure login through Discord OAuth via jotun.games backend
- Implementation: Complete OAuth flow with role validation and session management
- Features: Automatic role detection, secure token handling, graceful error handling
- Integration: Seamless integration with WordPress user system

**Dashboard Configuration System**
- Functionality: Dynamic admin menu reorganization with normalized database storage
- Implementation: Flexible menu system with drag-and-drop organization
- Features: Custom sections, menu ordering, permission-based visibility
- Storage: Normalized database structure for scalability

**Page Permissions Configuration**
- Functionality: Role-based access control for all system pages
- Implementation: Discord role hierarchy integration with WordPress capabilities
- Features: Fine-grained permissions, role inheritance, access logging
- Roles: Norn > Aesir > All Staff > Admin > Staff > Valkyrie > Vithar

**Database API Infrastructure**
- Functionality: Comprehensive REST endpoints for all system data
- Implementation: Full CRUD operations with authentication and validation
- Features: Rate limiting, error handling, data sanitization
- Coverage: Players, shops, items, transactions, ledgers, all jotun_* tables

**Shop Management Core System**
- Functionality: Multi-type shop creation and management
- Implementation: Flexible shop type system with role-based access
- Features: Shop creation, type management, rotation support
- Types: Standard shops, Turn-In Only shops, custom shop types

### 🚧 **IN PROGRESS FEATURES**

**Shop Items Management (Recently Enhanced)**
- Functionality: Complete item management with master list integration
- Current Status: Core functionality implemented, testing in progress
- Recent Enhancements:
  - ✅ Fixed database schema issues preventing item additions
  - ✅ Added unlimited stock checkbox functionality
  - ✅ Enhanced pricing system (stores as Coins, displays Ymir+Coins)
  - ✅ Implemented Turn-In shop specific fields (turn-in quantity/requirements)
  - ✅ Fixed master item list search with live results and dropdown
  - ✅ Added proper field toggling based on shop type

**Advanced Shop Features (In Development)**
- Custom price overrides with currency conversion (Ymir ↔ Coins)
- Stock quantity management with unlimited stock options
- Item rotation system for seasonal/event items
- Turn-in tracking for community events
- Integration with master item database

### 📋 **PLANNED FEATURES**

## Essential Features

**Player Shop Creation System (Chosen Role)**
- Functionality: Allow Chosen players to create and manage personal shops
- Purpose: Enable player-driven economy with custom shops
- Features: Shop creation wizard, item management, permission delegation
- Access Control: Chosen role and above can create shops

**Shop Permission Delegation**
- Functionality: Shop owners can grant access to other players
- Purpose: Enable collaborative shop management and trusted operators
- Features: Granular permissions (view/edit/manage), temporary access, audit logging
- Use Cases: Trusted friends, temporary shop-sitters, co-op businesses

**Unified Teller System**
- Functionality: Single interface for all shop transactions across multiple shops
- Purpose: Streamline transaction processing for staff and reduce interface switching
- Features: Multi-shop view, bulk operations, transaction batching, real-time updates
- Multi-User: Multiple staff can operate simultaneously on same interface

**Transaction Recording (Multi-Shop)**
- Functionality: Record purchases/sales across Admin, Popup, Haldore, and Beehive shops
- Purpose: Track all economic activity with proper validation and archival
- Integration: Seamless integration with existing shop types and new player shops

**Item Management System**
- Functionality: Centralized item database with pricing and availability
- Purpose: Maintain consistency across all shops and transaction types
- Features: Master item list, price management, availability tracking, bulk updates

**Player Rename Functionality**
- Functionality: Update player names across all systems and historical data
- Purpose: Maintain data integrity when players change names
- Features: Bulk rename across all tables, change logging, rollback capability

**Ledger Management**
- Functionality: Advanced transaction ledger with archival and world reset support
- Purpose: Handle periodic data management and special game mechanics
- Features: Automated archival, legacy item tracking, world reset procedures

**Advanced Analytics Dashboard**
- Functionality: Economic insights and transaction analytics
- Purpose: Provide data-driven insights for server economy management
- Features: Transaction trends, popular items, player activity, shop performance

## Technical Implementation Details

**Database Architecture**
- Custom table prefix: `jotun_` for all plugin tables
- Normalized database design for scalability
- Comprehensive foreign key relationships
- Automated migration system for schema updates

**API Architecture** 
- RESTful endpoints with WordPress nonce authentication
- Namespace: `jotunheim/v1` for all custom endpoints
- Rate limiting and error handling
- Consistent response format with success/error states

**Security Implementation**
- Discord OAuth integration with role-based permissions
- WordPress capability system integration
- SQL injection prevention with prepared statements
- Input sanitization and validation on all endpoints

**Performance Optimizations**
- Efficient database queries with proper indexing
- Conditional asset loading (only when shortcodes present)
- Caching for frequently accessed data
- Optimized REST API responses

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

## Known Issues & Technical Debt

**Unified Teller Needs**
- Needs: 
   - Drop down menu to select shop
   - Access to drop downs should be determined by discord role permissions already set in shop manager. 

## Integration Opportunities

**Spark Framework Integration**
- Source: https://github.com/Thor-Jotunheim/jotunheim-admin-dash.git
- Potential: Reusable components and design patterns from Spark-based prototype
- Consideration: Evaluate compatibility with WordPress plugin architecture
- Status: Available for selective integration

## Future Enhancements

**In-Game Integration**
- Real-time shop data via game mod integration
- Automatic transaction recording from in-game purchases
- Live inventory sync between game and web interface

**Mobile Optimization**
- Responsive design improvements for mobile shop management
- Touch-optimized interfaces for tablet-based POS systems
- Offline capability for transaction recording

**Advanced Economics**
- Dynamic pricing based on supply/demand
- Seasonal event shop automation
- Economic trend analysis and reporting
- Integration with external economy tracking tools 