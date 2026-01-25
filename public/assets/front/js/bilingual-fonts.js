/**
 * Intelligent Bilingual Font System
 * Automatically detects Arabic/English text and applies appropriate fonts
 * Created: 2026-01-25
 */

(function() {
    'use strict';
    
    // Arabic Unicode range detection
    const arabicRegex = /[\u0600-\u06FF\u0750-\u077F\u08A0-\u08FF\uFB50-\uFDFF\uFE70-\uFEFF]/;
    
    /**
     * Detect if text contains Arabic characters
     */
    function containsArabic(text) {
        return arabicRegex.test(text);
    }
    
    /**
     * Detect if text contains English characters
     */
    function containsEnglish(text) {
        return /[a-zA-Z]/.test(text);
    }
    
    /**
     * Get dominant language in text
     */
    function getDominantLanguage(text) {
        if (!text || text.trim() === '') return null;
        
        const arabicChars = (text.match(arabicRegex) || []).length;
        const englishChars = (text.match(/[a-zA-Z]/g) || []).length;
        
        if (arabicChars === 0 && englishChars === 0) return null;
        if (arabicChars > englishChars) return 'ar';
        if (englishChars > arabicChars) return 'en';
        return 'mixed';
    }
    
    /**
     * Apply language attribute to element
     */
    function applyLanguageAttribute(element) {
        // Skip if already has lang attribute
        if (element.hasAttribute('lang')) return;
        
        // Get text content
        const text = element.textContent || element.innerText || '';
        const language = getDominantLanguage(text);
        
        if (language && language !== 'mixed') {
            element.setAttribute('lang', language);
            element.setAttribute('dir', language === 'ar' ? 'rtl' : 'ltr');
        }
    }
    
    /**
     * Process all text elements
     */
    function processTextElements() {
        const selectors = [
            'p', 'span', 'div', 'a', 'li', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
            'label', 'button', 'td', 'th', '.product-title', '.product-name',
            '.product-description', '.category-name', '.item-title'
        ];
        
        selectors.forEach(selector => {
            const elements = document.querySelectorAll(selector);
            elements.forEach(element => {
                // Only process if element has direct text content
                if (element.childNodes.length === 1 && element.childNodes[0].nodeType === 3) {
                    applyLanguageAttribute(element);
                }
            });
        });
    }
    
    /**
     * Apply font to specific element
     */
    function applyFontToElement(element, language) {
        const arabicFont = getComputedStyle(document.documentElement)
            .getPropertyValue('--arabic-font-family').trim();
        const englishFont = getComputedStyle(document.documentElement)
            .getPropertyValue('--english-font-family').trim();
        
        if (language === 'ar' && arabicFont) {
            element.style.fontFamily = arabicFont;
        } else if (language === 'en' && englishFont) {
            element.style.fontFamily = englishFont;
        }
    }
    
    /**
     * Initialize on DOM ready
     */
    function init() {
        // Process existing elements
        processTextElements();
        
        // Watch for dynamically added content
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                mutation.addedNodes.forEach(function(node) {
                    if (node.nodeType === 1) { // Element node
                        applyLanguageAttribute(node);
                        
                        // Process children
                        const children = node.querySelectorAll('p, span, div, a, li, h1, h2, h3, h4, h5, h6');
                        children.forEach(child => applyLanguageAttribute(child));
                    }
                });
            });
        });
        
        // Start observing
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
        
        console.log('✓ Professional Bilingual Font System Activated');
    }
    
    /**
     * Public API
     */
    window.BilingualFonts = {
        init: init,
        detectLanguage: getDominantLanguage,
        containsArabic: containsArabic,
        containsEnglish: containsEnglish,
        applyToElement: applyLanguageAttribute
    };
    
    // Auto-initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    
})();

/**
 * Enhanced Input/Textarea Font Detection
 * Automatically switches font as user types
 */
(function() {
    'use strict';
    
    function handleInput(event) {
        const element = event.target;
        const text = element.value;
        
        if (!text || text.trim() === '') return;
        
        const language = window.BilingualFonts.detectLanguage(text);
        
        if (language && language !== 'mixed') {
            element.setAttribute('lang', language);
            element.setAttribute('dir', language === 'ar' ? 'rtl' : 'ltr');
        }
    }
    
    function initInputs() {
        const inputs = document.querySelectorAll('input[type="text"], input[type="search"], textarea');
        inputs.forEach(input => {
            input.addEventListener('input', handleInput);
            input.addEventListener('change', handleInput);
            
            // Check initial value
            if (input.value) {
                handleInput({ target: input });
            }
        });
    }
    
    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initInputs);
    } else {
        initInputs();
    }
    
    // Watch for dynamically added inputs
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            mutation.addedNodes.forEach(function(node) {
                if (node.nodeType === 1) {
                    if (node.matches('input[type="text"], input[type="search"], textarea')) {
                        node.addEventListener('input', handleInput);
                        node.addEventListener('change', handleInput);
                    }
                    
                    const inputs = node.querySelectorAll('input[type="text"], input[type="search"], textarea');
                    inputs.forEach(input => {
                        input.addEventListener('input', handleInput);
                        input.addEventListener('change', handleInput);
                    });
                }
            });
        });
    });
    
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
    
})();
