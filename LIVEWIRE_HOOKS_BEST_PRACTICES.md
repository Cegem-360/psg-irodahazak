# Livewire Hooks Best Practices

## Overview
This document provides best practices for using Livewire 3.x hooks to integrate JavaScript components with Livewire state management, specifically for Google Maps integration with paginated/filtered data.

## Problem: Infinite Update Loops

### The Issue
When using Livewire hooks incorrectly, you can create infinite update loops:

```javascript
// ❌ WRONG - Can cause infinite loops
$wire.$hook('morph', () => {
    $wire.$call('getOfficesForMap').then((data) => {
        updateMap(data);
    });
});
```

The problem occurs because:
1. `morph` hook fires when DOM updates
2. `$wire.$call()` triggers a server request
3. Server response causes another `morph`
4. This creates an infinite loop

### The Solution
Use the `commit` hook with proper guards:

```javascript
// ✅ CORRECT - Safe from infinite loops
let isUpdating = false;

$wire.$hook('commit', ({ succeed }) => {
    succeed(() => {
        if (isUpdating) return; // Guard against multiple calls
        
        setTimeout(() => {
            if (window.mapHandler && !isUpdating) {
                isUpdating = true;
                
                $wire.$call('getOfficesForMap').then((data) => {
                    window.mapHandler.refreshMarkers(data);
                }).finally(() => {
                    setTimeout(() => {
                        isUpdating = false;
                    }, 500);
                });
            }
        }, 150);
    });
});
```

## Livewire Hook Types

### 1. `morph` Hook
- **When it fires**: Every time the DOM is updated
- **Use case**: DOM manipulation that doesn't trigger server calls
- **Caution**: Avoid server calls in this hook

```javascript
$wire.$hook('morph', () => {
    // Safe: DOM-only operations
    updateUIState();
    
    // ❌ Dangerous: Can cause loops
    // $wire.$call('someMethod');
});
```

### 2. `commit` Hook
- **When it fires**: After a successful Livewire update
- **Use case**: Server calls that depend on updated state
- **Best practice**: Use with guards and delays

```javascript
$wire.$hook('commit', ({ succeed }) => {
    succeed(() => {
        // Safe place for server calls
        $wire.$call('getData').then(handleData);
    });
});
```

### 3. `message.sent` Hook
- **When it fires**: Before request is sent to server
- **Use case**: Loading states, request preparation

```javascript
$wire.$hook('message.sent', () => {
    showLoadingState();
});
```

### 4. `message.received` Hook
- **When it fires**: After server response received
- **Use case**: Hide loading states, handle responses

```javascript
$wire.$hook('message.received', () => {
    hideLoadingState();
});
```

## Best Practices for Map Integration

### 1. State Management
Always track update state to prevent conflicts:

```javascript
let isUpdating = false;
let lastUpdateTime = 0;

function safeUpdate() {
    const now = Date.now();
    if (isUpdating || (now - lastUpdateTime) < 1000) {
        return false;
    }
    
    isUpdating = true;
    lastUpdateTime = now;
    return true;
}
```

### 2. Error Handling
Always provide fallbacks:

```javascript
$wire.$call('getOfficesForMap').then((data) => {
    updateMap(data);
}).catch((error) => {
    console.error('Failed to fetch data:', error);
    // Use cached/static data as fallback
    updateMap(cachedData);
}).finally(() => {
    isUpdating = false;
});
```

### 3. Debouncing
For rapid updates, implement debouncing:

```javascript
let updateTimeout;

function debounceMapUpdate(data) {
    clearTimeout(updateTimeout);
    updateTimeout = setTimeout(() => {
        updateMap(data);
    }, 300);
}
```

## Implementation Examples

### Rent Offices (Coordinate-based)
```javascript
let isUpdating = false;

$wire.$hook('commit', ({ succeed }) => {
    succeed(() => {
        if (isUpdating) return;
        
        setTimeout(() => {
            if (window.rentOfficesMapHandler && !isUpdating) {
                isUpdating = true;
                
                $wire.$call('getOfficesForMap').then((data) => {
                    window.rentOfficesMapHandler.refreshMarkers(data);
                }).catch((error) => {
                    console.error('Failed to fetch data:', error);
                    const fallbackData = @json($this->getOfficesForMap());
                    window.rentOfficesMapHandler.refreshMarkers(fallbackData);
                }).finally(() => {
                    setTimeout(() => {
                        isUpdating = false;
                    }, 500);
                });
            }
        }, 150);
    });
});
```

### Sale Offices (Geocoding-based)
Same pattern, but with geocoding handler:

```javascript
// Same pattern as rent offices, but using saleOfficesMapHandler
window.saleOfficesMapHandler.refreshMarkers(data);
```

## Debugging Tips

### 1. Console Logging
Add strategic logging to track hook execution:

```javascript
$wire.$hook('commit', ({ succeed }) => {
    console.log('Commit hook fired');
    succeed(() => {
        console.log('Commit succeed callback fired');
        // Your code here
    });
});
```

### 2. State Monitoring
Monitor update state in browser console:

```javascript
// In browser console
window.mapUpdateState = { isUpdating: false, count: 0 };
```

### 3. Network Monitoring
Watch Network tab for repeated requests that indicate loops.

## Common Pitfalls

### 1. Multiple Hook Registrations
```javascript
// ❌ WRONG - Registering hooks multiple times
function setupMap() {
    $wire.$hook('commit', handleUpdate); // Registered again each call
}

// ✅ CORRECT - Register hooks once
let hooksRegistered = false;
function setupMap() {
    if (!hooksRegistered) {
        $wire.$hook('commit', handleUpdate);
        hooksRegistered = true;
    }
}
```

### 2. Missing Error Handling
```javascript
// ❌ WRONG - No error handling
$wire.$call('getOfficesForMap').then(updateMap);

// ✅ CORRECT - With error handling
$wire.$call('getOfficesForMap')
    .then(updateMap)
    .catch(handleError);
```

### 3. Immediate Server Calls
```javascript
// ❌ WRONG - Immediate call can cause issues
$wire.$hook('morph', () => {
    $wire.$call('getData');
});

// ✅ CORRECT - Delayed with guards
$wire.$hook('commit', ({ succeed }) => {
    succeed(() => {
        setTimeout(() => {
            if (!isUpdating) {
                $wire.$call('getData');
            }
        }, 150);
    });
});
```

## Performance Considerations

1. **Limit Hook Executions**: Use state flags to prevent unnecessary work
2. **Debounce Updates**: For rapid changes, debounce map updates
3. **Cache Data**: Store last known good data for fallbacks
4. **Cleanup**: Remove markers before adding new ones
5. **Error Recovery**: Always provide fallback data sources

## Migration Notes

When upgrading from older Livewire versions:
- Replace `document.addEventListener('livewire:update')` with `$wire.$hook('commit')`
- Replace `@this.call()` with `$wire.$call()`
- Add proper error handling and state management
- Test for infinite loops in development

## Testing

To test your implementation:
1. Open browser dev tools
2. Navigate through pagination rapidly
3. Apply/remove filters quickly
4. Monitor Network tab for excessive requests
5. Check Console for errors or warnings
6. Verify map updates correctly without loops
