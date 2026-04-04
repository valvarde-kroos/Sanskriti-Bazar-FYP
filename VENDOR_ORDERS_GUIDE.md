# Simple Vendor Orders Management Guide

## Overview
A clean, beginner-friendly interface for vendors to manage customer orders.

## What You See
Each order is displayed in a simple card showing:
- **Order ID**: Unique order number (e.g., Order #0001)
- **Customer Name**: Who placed the order
- **Product Name**: Which product was ordered (e.g., Bansuri, Khaijhandi)
- **Quantity**: How many pieces ordered
- **Total Price**: Total amount in Rupees
- **Status**: Current order status with color coding

## Order Status Colors
- **Yellow (Pending)**: New orders waiting for your decision
- **Blue (Accepted)**: Orders you've accepted and need to prepare
- **Green (Delivered)**: Completed orders
- **Red (Rejected)**: Orders you couldn't fulfill

## Simple Actions

### 1. Accept Order
- **When**: Order status is "Pending" and you can fulfill it
- **Button**: Green "Accept Order" button
- **What happens**: Order moves to "Accepted" status, stock is reduced

### 2. Reject Order  
- **When**: Order status is "Pending" but you can't fulfill it
- **Button**: Red "Reject Order" button
- **What happens**: Order moves to "Rejected" status

### 3. Mark as Delivered
- **When**: Order status is "Accepted" and you've sent the product
- **Button**: Blue "Mark as Delivered" button
- **What happens**: Order moves to "Delivered" status

## How It Works

### Step 1: New Order Arrives
- Order appears with yellow "Pending" status
- You see both "Accept Order" and "Reject Order" buttons
- System checks if you have enough stock

### Step 2: Accept or Reject
- Click "Accept Order" (green button) if you can fulfill it
- Click "Reject Order" (red button) if you cannot fulfill it

### Step 3: Deliver the Order
- Accepted orders show "Accepted" status (blue)
- Prepare and ship the product
- Click "Mark as Delivered" when done

## Important Rules
- You can only see orders for YOUR products
- You cannot delete any orders
- You cannot change customer information
- You cannot edit payment details
- Stock is automatically managed when you accept orders

## Mobile Friendly
- Works perfectly on phones and tablets
- Large, easy-to-tap buttons
- Clear text and spacing
- No complex menus or icons

This simple system helps you manage orders efficiently without confusion!