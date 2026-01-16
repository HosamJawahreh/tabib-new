#!/usr/bin/env python3
"""
Script to analyze and fix product status field by comparing old and new databases.
The old database uses 'published' or 'pending' status values.
The new database uses status=1 for all products (needs fixing).
"""

import re
import sys

def parse_sql_products(sql_file):
    """Parse products from SQL dump file."""
    products = {}

    with open(sql_file, 'r', encoding='utf-8') as f:
        content = f.read()

    # Find all INSERT statements
    pattern = r"INSERT INTO `ec_products`.*?VALUES\s*(.*?);"
    matches = re.finditer(pattern, content, re.DOTALL | re.MULTILINE)

    for match in matches:
        values_section = match.group(1)

        # Split by rows - each row starts with a '(' and ends with '),\n' or ')'
        rows = re.findall(r'\((.*?)\)(?:,\s*\n|\s*$)', values_section, re.DOTALL)

        for row in rows:
            # Split values carefully (handling escaped quotes and nulls)
            values = parse_row_values(row)

            if len(values) >= 36:
                product_id = values[0].strip().strip("'\"")
                product_name = values[1].strip().strip("'\"")
                status = values[4].strip().strip("'\"")

                products[product_name] = {
                    'id': product_id,
                    'name': product_name,
                    'status': status
                }

    return products

def parse_row_values(row_str):
    """Parse comma-separated values from a row, handling quoted strings and NULLs."""
    values = []
    current_value = ""
    in_quotes = False
    quote_char = None
    escaped = False

    i = 0
    while i < len(row_str):
        char = row_str[i]

        if escaped:
            current_value += char
            escaped = False
            i += 1
            continue

        if char == '\\':
            escaped = True
            current_value += char
            i += 1
            continue

        if char in ('"', "'") and not in_quotes:
            in_quotes = True
            quote_char = char
            current_value += char
            i += 1
            continue

        if char == quote_char and in_quotes:
            in_quotes = False
            quote_char = None
            current_value += char
            i += 1
            continue

        if char == ',' and not in_quotes:
            values.append(current_value.strip())
            current_value = ""
            i += 1
            # Skip whitespace after comma
            while i < len(row_str) and row_str[i] in (' ', '\t', '\n', '\r'):
                i += 1
            continue

        current_value += char
        i += 1

    # Add the last value
    if current_value:
        values.append(current_value.strip())

    return values

def main():
    print("=" * 80)
    print("PRODUCT STATUS ANALYZER & FIXER")
    print("=" * 80)
    print()

    old_sql_file = '/home/hjawahreh/Desktop/Projects/file/public/ec_products (2).sql'

    print(f"📂 Reading old database: {old_sql_file}")
    old_products = parse_sql_products(old_sql_file)

    print(f"✅ Found {len(old_products)} products in old database")
    print()

    # Count status values in old database
    published_count = sum(1 for p in old_products.values() if p['status'] == 'published')
    pending_count = sum(1 for p in old_products.values() if p['status'] == 'pending')

    print("📊 OLD DATABASE ANALYSIS:")
    print(f"   ✓ Published (Active): {published_count}")
    print(f"   ✗ Pending (Inactive): {pending_count}")
    print()

    # Generate SQL update statements
    update_statements = []

    for product_name, product_data in old_products.items():
        status = product_data['status']
        # Escape single quotes in product name for SQL
        safe_name = product_name.replace("'", "\\'")

        update_statements.append({
            'name': product_name,
            'status': status,
            'sql': f"UPDATE ec_products SET status = '{status}' WHERE name = '{safe_name}';"
        })

    # Write SQL file
    sql_output_file = '/home/hjawahreh/Desktop/Projects/file/update-product-status.sql'

    with open(sql_output_file, 'w', encoding='utf-8') as f:
        f.write("-- ============================================\n")
        f.write("-- PRODUCT STATUS UPDATE SCRIPT\n")
        f.write("-- ============================================\n")
        f.write(f"-- Total Products: {len(old_products)}\n")
        f.write(f"-- Published (Active): {published_count}\n")
        f.write(f"-- Pending (Inactive): {pending_count}\n")
        f.write("-- ============================================\n")
        f.write("-- Generated: Run this script to update product status\n")
        f.write("-- ============================================\n\n")

        f.write("-- First, show current status distribution\n")
        f.write("SELECT status, COUNT(*) as count FROM ec_products GROUP BY status;\n\n")

        f.write("-- Update all products based on old database status\n")
        for item in update_statements:
            f.write(item['sql'] + '\n')

        f.write("\n-- Verify the updates\n")
        f.write("SELECT status, COUNT(*) as count FROM ec_products GROUP BY status;\n")

    print(f"📝 Generated SQL update script: {sql_output_file}")
    print()

    # Generate detailed report
    report_file = '/home/hjawahreh/Desktop/Projects/file/product-status-report.txt'

    with open(report_file, 'w', encoding='utf-8') as f:
        f.write("=" * 80 + "\n")
        f.write("PRODUCT STATUS DETAILED REPORT\n")
        f.write("=" * 80 + "\n\n")

        f.write(f"Total Products: {len(old_products)}\n")
        f.write(f"Published (Active): {published_count}\n")
        f.write(f"Pending (Inactive): {pending_count}\n\n")

        f.write("=" * 80 + "\n")
        f.write("PUBLISHED PRODUCTS (ACTIVE)\n")
        f.write("=" * 80 + "\n")
        for product_name, product_data in sorted(old_products.items()):
            if product_data['status'] == 'published':
                f.write(f"  ✓ {product_name}\n")

        f.write("\n")
        f.write("=" * 80 + "\n")
        f.write("PENDING PRODUCTS (INACTIVE)\n")
        f.write("=" * 80 + "\n")
        for product_name, product_data in sorted(old_products.items()):
            if product_data['status'] == 'pending':
                f.write(f"  ✗ {product_name}\n")

    print(f"📊 Generated detailed report: {report_file}")
    print()

    print("=" * 80)
    print("SUMMARY")
    print("=" * 80)
    print(f"📌 Total Products in Old Database: {len(old_products)}")
    print(f"✅ Published (Active) Products: {published_count}")
    print(f"❌ Pending (Inactive) Products: {pending_count}")
    print()
    print("📝 Next Steps:")
    print("   1. Review the generated files:")
    print(f"      - {sql_output_file}")
    print(f"      - {report_file}")
    print("   2. Connect to your database")
    print("   3. Run the SQL update script to fix product statuses")
    print()
    print("=" * 80)

if __name__ == '__main__':
    try:
        main()
    except Exception as e:
        print(f"❌ Error: {e}", file=sys.stderr)
        import traceback
        traceback.print_exc()
        sys.exit(1)
