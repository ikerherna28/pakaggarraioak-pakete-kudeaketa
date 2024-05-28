// import java.util.Properties;
// import javax.mail.Message;
// import javax.mail.MessagingException;
// import javax.mail.PasswordAuthentication;
// import javax.mail.Session;
// import javax.mail.Transport;
// import javax.mail.internet.*;

// public class SendEmail {
//     public static void main(String[] args) {
//         if (args.length < 2) {
//             System.out.println("Usage: java SendEmail <email> <verification_code>");
//             return;
//         }

//         String to = args[0];
//         String verificationCode = args[1];

//         // Configuración del servidor de correo
//         String host = "smtp.gmail.com";
//         final String user = "pakaggarraioak@gmail.com";
//         final String password = "ykljrzujpjujgvjy";

//         // Propiedades del sistema
//         Properties properties = System.getProperties();
//         properties.setProperty("mail.smtp.host", host);
//         properties.setProperty("mail.smtp.port", "587"); // Puerto SMTP de Gmail
//         properties.setProperty("mail.smtp.auth", "true");
//         properties.setProperty("mail.smtp.starttls.enable", "true");

//         // Obtener la sesión predeterminada
//         Session session = Session.getDefaultInstance(properties,
//                 new javax.mail.Authenticator() {
//                     protected PasswordAuthentication getPasswordAuthentication() {
//                         return new PasswordAuthentication(user, password);
//                     }
//                 });

//         try {
//             // Crear un objeto MimeMessage predeterminado
//             MimeMessage message = new MimeMessage(session);

//             // Remitente
//             message.setFrom(new InternetAddress(user));

//             // Destinatario
//             message.addRecipient(Message.RecipientType.TO, new InternetAddress(to));

//             // Asunto del correo
//             message.setSubject("Código de Verificación");

//             // Mensaje
//             message.setText("Tu código de verificación es: " + verificationCode);

//             // Enviar mensaje
//             Transport.send(message);
//             System.out.println("Correo enviado con éxito...");
//         } catch (MessagingException mex) {
//             System.err.println("Error al enviar el correo: " + mex.getMessage());
//             mex.printStackTrace();
//         }
//     }
// }
