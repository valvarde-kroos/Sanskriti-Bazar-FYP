# Color Scheme Reference

## Primary Colors

### Gradient Colors
- **Primary Purple**: `#667eea` (RGB: 102, 126, 234)
- **Secondary Purple**: `#764ba2` (RGB: 118, 75, 162)
- **Gradient**: `linear-gradient(135deg, #667eea 0%, #764ba2 100%)`

### Text Colors
- **Dark Text**: `#2d3748` (Headings, important text)
- **Medium Text**: `#718096` (Secondary text, descriptions)
- **Light Text**: `#a0aec0` (Placeholders)

### Background Colors
- **White**: `#FFFFFF` (Cards, forms)
- **Light Gray**: `#f7fafc` (Input backgrounds)
- **Border Gray**: `#e2e8f0` (Borders, dividers)

### Status Colors
- **Success Green**: `#d4edda` (background), `#155724` (text), `#28a745` (border)
- **Error Red**: `#e53e3e` (error messages)

## Design Features

### Shadows
- **Card Shadow**: `0 20px 60px rgba(0, 0, 0, 0.3)`
- **Button Shadow**: `0 4px 15px rgba(102, 126, 234, 0.4)`
- **Hover Shadow**: `0 6px 20px rgba(102, 126, 234, 0.6)`
- **Dashboard Card**: `0 12px 30px rgba(102, 126, 234, 0.2)`

### Border Radius
- **Large**: `20px` (Main cards)
- **Medium**: `16px` (Dashboard cards)
- **Small**: `10px` (Inputs, buttons)

### Transitions
- **Standard**: `all 0.3s ease`
- **Transform**: `transform 0.3s ease`

## Typography

### Font Sizes
- **Large Heading**: `42px` (Welcome text)
- **Page Heading**: `36px` (Dashboard titles)
- **Section Heading**: `32px` (Form titles)
- **Card Heading**: `22px` (Action cards)
- **Body Text**: `15-18px`
- **Small Text**: `13-14px` (Labels, errors)

### Font Weights
- **Bold**: `700` (Headings)
- **Semi-Bold**: `600` (Labels, buttons)
- **Normal**: `400` (Body text)

## Responsive Breakpoints
- **Mobile**: `max-width: 768px`
  - Stack form sections vertically
  - Reduce padding
  - Adjust font sizes

## Animation Effects

### Hover Effects
- **Lift**: `translateY(-2px)` to `translateY(-8px)`
- **Shadow Increase**: Larger, more prominent shadows
- **Color Shift**: Border color changes to primary purple

### Focus Effects
- **Input Focus**: 
  - Border color: `#667eea`
  - Box shadow: `0 0 0 3px rgba(102, 126, 234, 0.1)`
  - Transform: `translateY(-1px)`

### Button Effects
- **Hover**: Lift up with enhanced shadow
- **Active**: Return to original position

## Usage Guidelines

### When to Use Primary Gradient
- Backgrounds for important sections (left panel)
- Primary action buttons
- Accent elements (top borders on cards)

### When to Use Solid Colors
- Text content
- Form inputs
- Card backgrounds
- Borders

### Accessibility
- All text colors meet WCAG AA contrast requirements
- Focus states are clearly visible
- Interactive elements have clear hover states
