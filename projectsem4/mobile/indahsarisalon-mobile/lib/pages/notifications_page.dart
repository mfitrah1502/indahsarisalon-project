import 'package:flutter/material.dart';
import 'manage_services_page.dart';

class NotificationsPage extends StatefulWidget {
  const NotificationsPage({super.key});

  @override
  State<NotificationsPage> createState() => _NotificationsPageState();
}

class _NotificationsPageState extends State<NotificationsPage> {1
  int _selectedIndex = 0; // Same as home for demonstration
  final Color darkBlue = const Color(0xFF02365A);
  final Color scaffoldBg = const Color(0xFFF6F8FA);
  final Color mutedText = const Color(0xFF64748B);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: scaffoldBg,
      body: SafeArea(
        child: Column(
          children: [
            // AppBar / Header
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 24.0, vertical: 20.0),
              child: Row(
                children: [
                  GestureDetector(
                    onTap: () {
                      Navigator.pop(context);
                    },
                    child: Icon(Icons.arrow_back, color: darkBlue, size: 28),
                  ),
                  const SizedBox(width: 16),
                  Text(
                    "Notifications",
                    style: TextStyle(
                      color: darkBlue,
                      fontSize: 24,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                ],
              ),
            ),
            
            // Subheader (Updates & Mark Read)
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 24.0),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  Text(
                    "You have 4 new updates",
                    style: TextStyle(
                      color: const Color(0xFF4B5563),
                      fontSize: 15,
                      fontWeight: FontWeight.w500,
                    ),
                  ),
                  GestureDetector(
                    onTap: () {},
                    child: Text(
                      "Mark all as read",
                      style: TextStyle(
                        color: darkBlue,
                        fontSize: 14,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                  ),
                ],
              ),
            ),
            
            const SizedBox(height: 24),

            // Notifications List
            Expanded(
              child: SingleChildScrollView(
                padding: const EdgeInsets.symmetric(horizontal: 24.0),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    // TODAY Section
                    Text(
                      "TODAY",
                      style: TextStyle(
                        fontSize: 12,
                        fontWeight: FontWeight.bold,
                        letterSpacing: 1.2,
                        color: const Color(0xFF4B5563),
                      ),
                    ),
                    const SizedBox(height: 16),
                    
                    _buildNotificationCard(
                      title: "New Booking",
                      timeText: "10 mins ago",
                      description: "Indah Glow Facial at 2:00 PM today.",
                      iconData: Icons.calendar_today_outlined,
                      iconBgColor: const Color(0xFFE4F0F9),
                      iconColor: darkBlue,
                      isUnread: true,
                      showButton: true,
                    ),
                    const SizedBox(height: 16),
                    
                    _buildNotificationCard(
                      title: "Payment Received",
                      timeText: "2 hours ago",
                      description: "\$85 from Jane Doe for Hair Styling.",
                      iconData: Icons.payments_outlined,
                      iconBgColor: const Color(0xFFFBE6D3),
                      iconColor: const Color(0xFF7A4A1E),
                      isUnread: true,
                      showButton: false,
                    ),
                    
                    const SizedBox(height: 32),

                    // EARLIER Section
                    Text(
                      "EARLIER",
                      style: TextStyle(
                        fontSize: 12,
                        fontWeight: FontWeight.bold,
                        letterSpacing: 1.2,
                        color: const Color(0xFF4B5563),
                      ),
                    ),
                    const SizedBox(height: 16),

                    _buildNotificationCard(
                      title: "System Update",
                      timeText: "1 day ago",
                      description: "New analytics features are now available in your Report tab.",
                      iconData: Icons.info_outline,
                      iconBgColor: const Color(0xFFD6E4F0), // slightly different grey/blue
                      iconColor: const Color(0xFF5A6A7D),
                      isUnread: false,
                      showButton: false,
                    ),
                    const SizedBox(height: 16),

                    _buildNotificationCard(
                      title: "New Customer",
                      timeText: "2 days ago",
                      description: "Mark Smith just registered an account.",
                      iconData: Icons.person_outline,
                      iconBgColor: const Color(0xFFDEE3E8),
                      iconColor: const Color(0xFF5A6A7D),
                      isUnread: false,
                      showButton: false,
                    ),
                    
                    const SizedBox(height: 32), // bottom padding
                  ],
                ),
              ),
            ),
          ],
        ),
      ),
      
      // Bottom Navigation Bar
      bottomNavigationBar: Container(
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: const BorderRadius.vertical(top: Radius.circular(24)),
          boxShadow: [
            BoxShadow(
              color: Colors.black.withOpacity(0.05),
              blurRadius: 20,
              offset: const Offset(0, -5),
            ),
          ],
        ),
        padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 16),
        child: SafeArea(
          top: false,
          child: Row(
            mainAxisAlignment: MainAxisAlignment.spaceAround,
            children: [
              _buildNavItem(0, "HOME", Icons.home_filled),
              _buildNavItem(1, "BOOKING", Icons.calendar_today_outlined),
              _buildNavItem(2, "SERVICES", Icons.content_cut_rounded),
              _buildNavItem(3, "REPORT", Icons.bar_chart_rounded),
              _buildNavItem(4, "SETTINGS", Icons.settings_outlined),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildNotificationCard({
    required String title,
    required String timeText,
    required String description,
    required IconData iconData,
    required Color iconBgColor,
    required Color iconColor,
    required bool isUnread,
    required bool showButton,
  }) {
    // If it's unread, we usually have a white background with shadow.
    // If read, a slightly transparent/flat view.
    Color cardBg = isUnread ? Colors.white : const Color(0xFFF1F4F8); // F1F4F8 matches 'earlier' card style
    
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: cardBg,
        borderRadius: BorderRadius.circular(16),
        boxShadow: isUnread 
          ? [
              BoxShadow(
                color: Colors.black.withOpacity(0.02),
                blurRadius: 10,
                offset: const Offset(0, 4),
              )
            ]
          : null, // Read items don't have shadow in the image
      ),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Icon Box
          Container(
            padding: const EdgeInsets.all(12),
            decoration: BoxDecoration(
              color: iconBgColor,
              borderRadius: BorderRadius.circular(12),
            ),
            child: Icon(iconData, color: iconColor, size: 28),
          ),
          const SizedBox(width: 16),
          
          // Content
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                // Title & Time Area
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    Text(
                      title,
                      style: TextStyle(
                        fontSize: 16,
                        fontWeight: FontWeight.bold,
                        color: const Color(0xFF1F2937),
                      ),
                    ),
                    Row(
                      children: [
                        Text(
                          timeText,
                          style: TextStyle(
                            fontSize: 12,
                            color: const Color(0xFF6B7280),
                          ),
                        ),
                        if (isUnread) ...[
                          const SizedBox(width: 8),
                          Container(
                            width: 8,
                            height: 8,
                            decoration: BoxDecoration(
                              color: darkBlue,
                              shape: BoxShape.circle,
                            ),
                          ),
                        ]
                      ],
                    ),
                  ],
                ),
                
                const SizedBox(height: 8),
                
                // Description
                Text(
                  description,
                  style: TextStyle(
                    fontSize: 14,
                    color: const Color(0xFF4B5563),
                    height: 1.4,
                  ),
                ),
                
                // Optional Action Button
                if (showButton) ...[
                  const SizedBox(height: 12),
                  SizedBox(
                    height: 36,
                    child: ElevatedButton(
                      style: ElevatedButton.styleFrom(
                        backgroundColor: darkBlue,
                        foregroundColor: Colors.white,
                        elevation: 0,
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(18),
                        ),
                        padding: const EdgeInsets.symmetric(horizontal: 20),
                      ),
                      onPressed: () {},
                      child: const Text(
                        "View Detail",
                        style: TextStyle(fontSize: 13, fontWeight: FontWeight.bold),
                      ),
                    ),
                  ),
                ]
              ],
            ),
          )
        ],
      ),
    );
  }

  Widget _buildNavItem(int index, String label, IconData icon) {
    // For demo, we leave 0 as selected if you just want to mimic the image.
    // However, the image doesn't actually have an active state in this screenshot. Let's make none active or unread the home.
    final isSelected = false; // The notifications page screenshot shows none of them explicitly active unless they tap it.
    
    return GestureDetector(
      onTap: () {
        setState(() {
          _selectedIndex = index;
        });
      },
      child: Column(
        mainAxisSize: MainAxisSize.min,
        children: [
          Icon(
            icon,
            color: isSelected ? darkBlue : mutedText,
            size: 26,
          ),
          const SizedBox(height: 6),
          Text(
            label,
            style: TextStyle(
              fontSize: 10,
              fontWeight: FontWeight.w800,
              color: isSelected ? darkBlue : mutedText,
              letterSpacing: 0.5,
            ),
          ),
        ],
      ),
    );
  }
}
