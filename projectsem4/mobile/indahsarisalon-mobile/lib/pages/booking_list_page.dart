import 'package:flutter/material.dart';
import 'home_page.dart';
import 'settings_page.dart';
import 'booking_page.dart';
import 'booking_details_page.dart';
import 'manage_services_page.dart';
import 'manage_services_page.dart';

List<Map<String, dynamic>> globalAppointments = [
  {
    "service": "Haircut & Styling",
    "stylist": "Maya",
    "date": "Oct 24, 2023",
    "time": "11:00 AM",
    "status": "CONFIRMED",
    "description": "Professional haircut, wash, and style by a senior stylist using premium organic products for a lasting finish.",
  },
  {
    "service": "Full Color & Highlight",
    "stylist": "Andre",
    "date": "Oct 26, 2023",
    "time": "02:30 PM",
    "status": "UPCOMING",
    "description": "Premium hair coloring and highlights tailored perfectly to your preferences and face shape.",
  },
  {
    "service": "Scalp Treatment",
    "stylist": "Sarah",
    "date": "Oct 29, 2023",
    "time": "09:00 AM",
    "status": "CONFIRMED",
    "description": "Deep cleansing and nourishing scalp treatment to promote healthy hair growth and relaxation.",
  },
  {
    "service": "Deep Conditioning",
    "stylist": "Maya",
    "date": "Nov 02, 2023",
    "time": "04:00 PM",
    "status": "CONFIRMED",
    "description": "Intensive moisture therapy to repair damaged hair and restore its natural shine and softness.",
  },
];

class BookingListPage extends StatefulWidget {
  const BookingListPage({super.key});

  @override
  State<BookingListPage> createState() => _BookingListPageState();
}

class _BookingListPageState extends State<BookingListPage> {
  final Color darkBlue = const Color(0xFF02365A);
  final Color scaffoldBg = const Color(0xFFF6F8FA);
  final Color mutedText = const Color(0xFF64748B);

  int _selectedIndex = 1; // 1 represents BOOKING tab

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: scaffoldBg,
      body: SafeArea(
        child: Column(
          children: [
            // Header
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 24.0, vertical: 20.0),
              child: Row(
                children: [
                  GestureDetector(
                    onTap: () {
                      // Navigate back to HomePage as requested
                      Navigator.pushAndRemoveUntil(
                        context,
                        MaterialPageRoute(builder: (context) => const HomePage()),
                        (route) => false,
                      );
                    },
                    child: Icon(Icons.arrow_back, color: darkBlue, size: 28),
                  ),
                  Expanded(
                    child: Center(
                      child: Padding(
                        padding: const EdgeInsets.only(right: 28.0),
                        child: Text(
                          "Bookings",
                          style: TextStyle(
                            color: darkBlue,
                            fontSize: 18,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                      ),
                    ),
                  ),
                ],
              ),
            ),

            Expanded(
              child: Stack(
                children: [
                  SingleChildScrollView(
                    padding: const EdgeInsets.symmetric(horizontal: 24.0),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        const SizedBox(height: 12),
                        Text(
                          "SCHEDULE OVERVIEW",
                          style: TextStyle(
                            fontSize: 11,
                            fontWeight: FontWeight.bold,
                            letterSpacing: 1.2,
                            color: mutedText,
                          ),
                        ),
                        const SizedBox(height: 4),
                        Text(
                          "Your Appointments",
                          style: TextStyle(
                            color: darkBlue,
                            fontSize: 28,
                            fontWeight: FontWeight.w900,
                          ),
                        ),
                        const SizedBox(height: 24),

                        // List of Appointments
                        ListView.separated(
                          shrinkWrap: true,
                          physics: const NeverScrollableScrollPhysics(),
                          itemCount: globalAppointments.length + 1, // extra for bottom padding
                          separatorBuilder: (context, index) => const SizedBox(height: 16),
                          itemBuilder: (context, index) {
                            if (index == globalAppointments.length) {
                              return const SizedBox(height: 80); // padding for FAB
                            }
                            final apt = globalAppointments[index];
                            final isConfirmed = apt["status"] == "CONFIRMED" || apt["status"] == "DONE";
                            
                            return GestureDetector(
                              onTap: () {
                                Navigator.push(
                                  context,
                                  MaterialPageRoute(builder: (context) => BookingDetailsPage(appointmentIndex: index)),
                                );
                              },
                              child: Container(
                              padding: const EdgeInsets.all(16),
                              decoration: BoxDecoration(
                                color: Colors.white,
                                borderRadius: BorderRadius.circular(16),
                                boxShadow: [
                                  BoxShadow(
                                    color: Colors.black.withOpacity(0.02),
                                    blurRadius: 10,
                                    offset: const Offset(0, 4),
                                  )
                                ],
                              ),
                              child: Column(
                                children: [
                                  Row(
                                    crossAxisAlignment: CrossAxisAlignment.start,
                                    children: [
                                      Container(
                                        width: 50,
                                        height: 50,
                                        decoration: BoxDecoration(
                                          borderRadius: BorderRadius.circular(12),
                                          color: const Color(0xFFE2E8F0),
                                        ),
                                        child: const Icon(Icons.person, color: Color(0xFF94A3B8), size: 28),
                                      ),
                                      const SizedBox(width: 16),
                                      Expanded(
                                        child: Column(
                                          crossAxisAlignment: CrossAxisAlignment.start,
                                          children: [
                                            Text(
                                              apt["service"],
                                              style: TextStyle(
                                                fontWeight: FontWeight.bold,
                                                fontSize: 16,
                                                color: darkBlue,
                                              ),
                                            ),
                                            const SizedBox(height: 2),
                                            Text(
                                              "with ${apt["stylist"]}",
                                              style: TextStyle(
                                                fontSize: 14,
                                                color: mutedText,
                                              ),
                                            ),
                                          ],
                                        ),
                                      ),
                                      Container(
                                        padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 6),
                                        decoration: BoxDecoration(
                                          color: isConfirmed ? const Color(0xFFE2E8F0) : const Color(0xFFFFEDD5),
                                          borderRadius: BorderRadius.circular(20),
                                        ),
                                        child: Text(
                                          apt["status"],
                                          style: TextStyle(
                                            fontSize: 9,
                                            fontWeight: FontWeight.w900,
                                            letterSpacing: 0.5,
                                            color: isConfirmed ? const Color(0xFF475569) : const Color(0xFF8C3310),
                                          ),
                                        ),
                                      ),
                                    ],
                                  ),
                                  const SizedBox(height: 16),
                                  Container(
                                    height: 1,
                                    color: const Color(0xFFF1F5F9),
                                  ),
                                  const SizedBox(height: 16),
                                  Row(
                                    children: [
                                      Row(
                                        children: [
                                          Icon(Icons.calendar_today_outlined, size: 14, color: mutedText),
                                          const SizedBox(width: 6),
                                          Text(
                                            apt["date"],
                                            style: TextStyle(
                                              fontSize: 12,
                                              fontWeight: FontWeight.w600,
                                              color: const Color(0xFF334155),
                                            ),
                                          ),
                                        ],
                                      ),
                                      const SizedBox(width: 24),
                                      Row(
                                        children: [
                                          Icon(Icons.access_time_filled, size: 14, color: mutedText),
                                          const SizedBox(width: 6),
                                          Text(
                                            apt["time"],
                                            style: TextStyle(
                                              fontSize: 12,
                                              fontWeight: FontWeight.w600,
                                              color: const Color(0xFF334155),
                                            ),
                                          ),
                                        ],
                                      ),
                                    ],
                                  )
                                ],
                              ),
                             ),
                            );
                          },
                        ),
                      ],
                    ),
                  ),
                  
                  // FAB (+) button to create new booking
                  Positioned(
                    bottom: 24,
                    right: 24,
                    child: GestureDetector(
                      onTap: () {
                        // Navigate to the first step of booking
                        Navigator.push(
                          context,
                          MaterialPageRoute(builder: (context) => const BookingPage()),
                        );
                      },
                      child: Container(
                        width: 56,
                        height: 56,
                        decoration: BoxDecoration(
                          color: darkBlue,
                          borderRadius: BorderRadius.circular(16),
                          boxShadow: [
                            BoxShadow(
                              color: darkBlue.withOpacity(0.3),
                              blurRadius: 10,
                              offset: const Offset(0, 5),
                            )
                          ],
                        ),
                        child: const Icon(Icons.add, color: Colors.white, size: 28),
                      ),
                    ),
                  )
                ],
              ),
            ),
          ],
        ),
      ),
      
      // Bottom Navigation Bar matching booking flow
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
              _buildNavItem(1, "BOOKING", Icons.calendar_today), 
              _buildNavItem(2, "SERVICES", Icons.content_cut_rounded),
              _buildNavItem(3, "REPORT", Icons.bar_chart_rounded),
              _buildNavItem(4, "SETTINGS", Icons.settings_outlined),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildNavItem(int index, String label, IconData icon) {
    final isSelected = _selectedIndex == index;
    

    
    return GestureDetector(
      onTap: () {
        if (index == 0) {
          Navigator.pushAndRemoveUntil(
            context,
            MaterialPageRoute(builder: (context) => const HomePage()),
            (route) => false,
          );
        } else if (index == 4) {
          Navigator.pushAndRemoveUntil(
            context,
            MaterialPageRoute(builder: (context) => const SettingsPage()),
            (route) => false,
          );
        } else if (index == 2) {
          Navigator.pushAndRemoveUntil(
            context,
            MaterialPageRoute(builder: (context) => const ManageServicesPage()),
            (route) => false,
          );
        } else {
          setState(() {
            _selectedIndex = index;
          });
        }
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
