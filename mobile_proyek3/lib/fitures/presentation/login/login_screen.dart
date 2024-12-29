import 'package:flutter/material.dart';

class LoginScreen extends StatelessWidget {
  const LoginScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('login')),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text('username',
                style: TextStyle(fontWeight: FontWeight.bold)),
            const SizedBox(height: 8.0),
            CustomeTextField(
              hintText: 'masukan username',
              prefixIcon: Icons.mail,
            ),
            const SizedBox(height: 16.0),
            const Text('password',
                style: TextStyle(fontWeight: FontWeight.bold)),
            const SizedBox(height: 8.0),
            CustomeTextField(
              hintText: 'masukan password',
              prefixIcon: Icons.lock,
            ),
            const SizedBox(height: 16.0),
            SizedBox(
              width: double.infinity,
              child: ElevatedButton(
                onPressed: () {},
                style: ElevatedButton.styleFrom(
                  backgroundColor: Color.fromARGB(255, 238, 143, 243),
                  foregroundColor: Colors.white,
                  padding: const EdgeInsets.symmetric(vertical: 16.0),
                  shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(8.0)),
                ),
                child: const Text('LOGIN'),
              ),
            ),
          ],
        ),
      ),
    );
  }
}

class CustomeTextField extends StatelessWidget {
  final String hintText;
  final IconData prefixIcon;
  final bool obscureText;

  const CustomeTextField(
      {super.key,
      required this.hintText,
      required this.prefixIcon,
      this.obscureText = false});

  @override
  Widget build(BuildContext context) {
    return TextField(
      obscureText: obscureText,
      decoration: InputDecoration(
        hintText: hintText,
        prefixIcon: Icon(prefixIcon),
        border: OutlineInputBorder(borderRadius: BorderRadius.circular(8.0)),
      ),
    );
  }
}
