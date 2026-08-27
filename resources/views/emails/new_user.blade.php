<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue sur GesPharma</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f8fafc; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #334155;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f8fafc; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" max-width="600" cellspacing="0" cellpadding="0" style="max-width: 600px; background-color: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #0f766e; padding: 32px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 700; tracking-tight: -0.025em;">GesPharma</h1>
                            <p style="color: #ccfbf1; margin: 8px 0 0 0; font-size: 14px;">Gestion Pharmaceutique & Stock</p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 32px;">
                            <h2 style="color: #0f172a; margin-top: 0; font-size: 20px; font-weight: 600;">Bonjour {{ $user->name }},</h2>
                            <p style="color: #475569; font-size: 15px; line-height: 1.6; margin-bottom: 24px;">
                                Un compte utilisateur a été créé pour vous sur l'application <strong>GesPharma</strong>. Vous pouvez dès à présent vous connecter pour accéder à l'application.
                            </p>
                            
                            <!-- Credentials Box -->
                            <div style="background-color: #f1f5f9; border-radius: 12px; border: 1px solid #cbd5e1; padding: 20px; margin-bottom: 28px;">
                                <h3 style="color: #1e293b; margin: 0 0 12px 0; font-size: 14px; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700;">Vos identifiants de connexion :</h3>
                                <p style="margin: 6px 0; font-size: 14px; color: #334155;">
                                    <strong>Identifiant / Email :</strong> <span style="color: #0f766e;">{{ $user->email }}</span>
                                </p>
                                <p style="margin: 6px 0; font-size: 14px; color: #334155;">
                                    <strong>Mot de passe :</strong> <span style="font-family: monospace; font-weight: 700; color: #0f172a;">{{ $password }}</span>
                                </p>
                            </div>

                            <!-- CTA Button -->
                            <div style="text-align: center; margin-bottom: 28px;">
                                <a href="{{ route('login') }}" style="display: inline-block; background-color: #0d9488; color: #ffffff; text-decoration: none; font-weight: 600; font-size: 15px; padding: 12px 32px; border-radius: 10px; box-shadow: 0 2px 4px rgba(13, 148, 136, 0.25);">
                                    Se connecter à l'application
                                </a>
                            </div>

                            <p style="color: #64748b; font-size: 13px; margin: 0; line-height: 1.5; text-align: center;">
                                Si le bouton ci-dessus ne fonctionne pas, copiez et collez l'adresse suivante dans votre navigateur :<br>
                                <a href="{{ route('login') }}" style="color: #0d9488;">{{ route('login') }}</a>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; border-top: 1px solid #f1f5f9; padding: 20px 32px; text-align: center; color: #94a3b8; font-size: 12px;">
                            © {{ date('Y') }} GesPharma. Tous droits réservés.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
