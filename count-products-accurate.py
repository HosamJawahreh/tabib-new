#!/usr/bin/env python3
"""
Accurate SQL Parser - Extract all products and their status from old database
"""

import re

def main():
    old_sql_file = '/home/hjawahreh/Desktop/Projects/file/public/ec_products (2).sql'
    
    print("=" * 80)
    print("ANALYZING OLD DATABASE - ACCURATE COUNT")
    print("=" * 80)
    print()
    
    with open(old_sql_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Count all INSERT statements with published status
    published_matches = re.findall(r"INSERT INTO `ec_products`.*?'published'", content, re.DOTALL)
    
    # Count all INSERT statements with pending status  
    pending_matches = re.findall(r"INSERT INTO `ec_products`.*?'pending'", content, re.DOTALL)
    
    # More accurate: count by looking at each row
    # Pattern: matches each complete row in INSERT statements
    all_rows = []
    
    # Find all INSERT blocks
    insert_pattern = r"INSERT INTO `ec_products`[^V]*VALUES\s*(.*?);"
    inserts = re.finditer(insert_pattern, content, re.DOTALL)
    
    total_published = 0
    total_pending = 0
    
    for insert in inserts:
        values_section = insert.group(1)
        
        # Count published in this section
        published_count = values_section.count("'published'")
        pending_count = values_section.count("'pending'")
        
        total_published += published_count
        total_pending += pending_count
    
    print(f"📊 OLD DATABASE COUNTS:")
    print(f"   ✅ Published (Active): {total_published}")
    print(f"   ❌ Pending (Inactive): {total_pending}")
    print(f"   📦 Total: {total_published + total_pending}")
    print()
    
    return total_published, total_pending

if __name__ == '__main__':
    main()
