import 'package:flutter/material.dart';
import 'package:flutter_dotenv/flutter_dotenv.dart';
import 'package:supabase_flutter/supabase_flutter.dart';

void main() async {
  // Wajib dipanggil sebelum fungsi async lainnya di main()
  WidgetsFlutterBinding.ensureInitialized();

  // Load konfigurasi dari file .env
  await dotenv.load(fileName: ".env");

  String supabaseUrl = dotenv.env['SUPABASE_URL'] ?? '';
  String supabaseAnonKey = dotenv.env['SUPABASE_ANON_KEY'] ?? '';

  bool isConnected = false;
  String statusMessage = "Sedang mencoba koneksi...";

  try {
    // Inisialisasi Supabase
    await Supabase.initialize(
      url: supabaseUrl,
      anonKey: supabaseAnonKey,
    );
    isConnected = true;
    statusMessage = "✅ Koneksi Supabase Berhasil!";
    print(statusMessage);
  } catch (e) {
    statusMessage = "❌ Koneksi Gagal:\n$e";
    print(statusMessage);
  }

  runApp(MyApp(statusMessage: statusMessage, isConnected: isConnected));
}

class MyApp extends StatelessWidget {
  final String statusMessage;
  final bool isConnected;

  const MyApp({
    super.key,
    required this.statusMessage,
    required this.isConnected,
  });

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Test Koneksi DB',
      theme: ThemeData(
        colorScheme: ColorScheme.fromSeed(seedColor: Colors.deepPurple),
        useMaterial3: true,
      ),
      home: MyHomePage(statusMessage: statusMessage, isConnected: isConnected),
    );
  }
}

class MyHomePage extends StatelessWidget {
  final String statusMessage;
  final bool isConnected;

  const MyHomePage({
    super.key,
    required this.statusMessage,
    required this.isConnected,
  });

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Test Koneksi Supabase'),
        backgroundColor: Theme.of(context).colorScheme.inversePrimary,
      ),
      body: Center(
        child: Padding(
          padding: const EdgeInsets.all(20.0),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            mainAxisSize: MainAxisSize.min,
            children: [
              Icon(
                isConnected ? Icons.check_circle : Icons.error,
                color: isConnected ? Colors.green : Colors.red,
                size: 80,
              ),
              const SizedBox(height: 20),
              const Text(
                'Status Database:',
                style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
              ),
              const SizedBox(height: 10),
              Text(
                statusMessage,
                textAlign: TextAlign.center,
                style: TextStyle(
                  fontSize: 16,
                  color: isConnected ? Colors.green : Colors.red,
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
