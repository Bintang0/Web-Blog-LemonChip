-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 29, 2025 at 12:24 PM
-- Server version: 8.0.30
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kpl`
--

-- --------------------------------------------------------

--
-- Table structure for table `article_keywords`
--

CREATE TABLE `article_keywords` (
  `id` int NOT NULL,
  `artikel_id` int NOT NULL,
  `keyword` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `article_keywords`
--

INSERT INTO `article_keywords` (`id`, `artikel_id`, `keyword`, `created_at`) VALUES
(20, 22, 'Artificial Intelligence', '2025-02-16 01:50:55'),
(21, 22, 'AI dalam kehidupan sehari-hari', '2025-02-16 01:50:55'),
(22, 22, 'Cara kerja AI', '2025-02-16 01:50:55'),
(23, 23, 'Cybersecurity', '2025-02-16 01:52:45'),
(24, 23, 'Keamanan data', '2025-02-16 01:52:45'),
(25, 23, 'Keamanan siber', '2025-02-16 01:52:45'),
(26, 24, 'Belajar coding', '2025-02-16 01:54:16'),
(27, 24, 'Bahasa pemrograman pemula', '2025-02-16 01:54:16'),
(28, 24, 'Cara memulai programming', '2025-02-16 01:54:16'),
(31, 25, 'teknologi', '2025-06-01 04:20:12'),
(32, 25, 'programming', '2025-06-01 04:20:12'),
(33, 25, 'ai', '2025-06-01 04:20:12');

-- --------------------------------------------------------

--
-- Table structure for table `artikel`
--

CREATE TABLE `artikel` (
  `id` int NOT NULL,
  `judul` varchar(100) NOT NULL,
  `tanggal` datetime NOT NULL,
  `isi` mediumtext NOT NULL,
  `gambar` varchar(50) NOT NULL,
  `UserId` int DEFAULT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `category_id` int DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `is_hidden` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `artikel`
--

INSERT INTO `artikel` (`id`, `judul`, `tanggal`, `isi`, `gambar`, `UserId`, `status`, `category_id`, `keywords`, `is_hidden`) VALUES
(22, 'Mengenal Artificial Intelligence: Cara Kerja dan Penerapannya di Kehidupan Sehari-hari', '2025-02-16 08:50:55', 'Artificial Intelligence (AI) atau kecerdasan buatan semakin berkembang dan digunakan di berbagai sektor kehidupan. Mulai dari asisten virtual seperti Siri dan Google Assistant, hingga mobil tanpa sopir, AI telah mengubah cara kita berinteraksi dengan teknologi.\r\n\r\nApa Itu Artificial Intelligence?\r\nAI adalah simulasi kecerdasan manusia yang diterapkan dalam mesin atau program komputer untuk berpikir dan belajar dari data yang diterima. AI dapat mengolah informasi, mengenali pola, dan membuat keputusan berdasarkan data yang telah dipelajari sebelumnya.\r\n\r\nCara Kerja AI\r\nAI bekerja dengan mengumpulkan data, memprosesnya menggunakan algoritma, dan kemudian membuat prediksi atau keputusan. Beberapa metode utama yang digunakan dalam AI meliputi:\r\n\r\nMachine Learning – AI belajar dari data tanpa perlu diprogram secara eksplisit.\r\nDeep Learning – Model AI yang lebih kompleks menggunakan jaringan saraf tiruan (Neural Networks).\r\nNatural Language Processing (NLP) – AI yang dapat memahami dan memproses bahasa manusia.\r\nPenerapan AI dalam Kehidupan Sehari-hari\r\n\r\nAsisten Virtual: Google Assistant, Alexa, dan Siri membantu pengguna dalam tugas sehari-hari.\r\nKeamanan Siber: AI dapat mendeteksi serangan malware dan melindungi data sensitif.\r\nRekomendasi Konten: Platform seperti Netflix dan YouTube menggunakan AI untuk menyarankan film atau video berdasarkan preferensi pengguna.\r\nKesehatan: AI membantu dokter dalam mendiagnosis penyakit melalui analisis data medis.\r\nKesimpulan\r\nPerkembangan AI terus meningkat, membawa dampak besar di berbagai bidang. Meskipun AI memberikan manfaat besar, penggunaannya tetap harus dikontrol agar tidak menggantikan peran manusia sepenuhnya.', '67b1447fc3a7c.jpg', 3, 'Dipublish', 3, 'Artificial Intelligence, AI dalam kehidupan sehari-hari, Cara kerja AI', 0),
(23, 'Cybersecurity: Cara Melindungi Data Pribadi dari Serangan Digital', '2025-02-16 08:52:45', 'Di era digital ini, keamanan data menjadi perhatian utama. Serangan siber seperti phishing, malware, dan ransomware semakin sering terjadi. Lalu, bagaimana cara melindungi data pribadi dari ancaman digital?\r\n\r\nJenis-Jenis Serangan Siber\r\n\r\nPhishing – Penipuan melalui email atau pesan untuk mencuri informasi sensitif.\r\nMalware – Perangkat lunak berbahaya yang bisa merusak atau mencuri data.\r\nRansomware – Serangan yang mengenkripsi data dan meminta tebusan untuk membukanya.\r\nCara Melindungi Data Pribadi\r\n\r\nGunakan Password yang Kuat: Kombinasikan huruf, angka, dan simbol untuk membuat kata sandi yang sulit ditebak.\r\nAktifkan Autentikasi Dua Faktor (2FA): Tambahan lapisan keamanan pada akun digital.\r\nHindari Klik Sembarangan: Jangan buka tautan atau lampiran dari sumber yang tidak dikenal.\r\nPerbarui Perangkat Lunak Secara Berkala: Patch keamanan terbaru dapat melindungi dari eksploitasi sistem.\r\nGunakan VPN Saat Mengakses Internet Publik: Mencegah pencurian data saat menggunakan Wi-Fi umum.\r\nKesimpulan\r\nMenjaga keamanan data pribadi adalah tanggung jawab semua pengguna internet. Dengan menerapkan langkah-langkah keamanan yang tepat, kita dapat mengurangi risiko serangan siber dan menjaga informasi tetap aman.', '67b144ed503bf.jpg', 3, 'Dipublish', 2, 'Cybersecurity, Keamanan data, Keamanan siber', 0),
(24, '10 Bahasa Pemrograman Terbaik untuk Pemula di Tahun 2025', '2025-02-16 08:54:16', 'Jika kamu baru ingin belajar coding, memilih bahasa pemrograman yang tepat sangat penting. Berikut adalah 10 bahasa pemrograman terbaik untuk pemula di tahun 2025:\r\n\r\n1. Python 🐍\r\nBahasa yang mudah dipahami dengan sintaks sederhana. Cocok untuk pengembangan web, data science, dan AI.\r\n\r\n2. JavaScript ⚡\r\nBahasa utama dalam pengembangan web. Digunakan untuk membuat website interaktif.\r\n\r\n3. Java ☕\r\nDigunakan untuk membuat aplikasi Android dan sistem backend yang skalabel.\r\n\r\n4. C# 🎮\r\nBahasa favorit untuk pengembangan game menggunakan Unity.\r\n\r\n5. Swift 🍏\r\nBahasa pemrograman terbaik untuk membangun aplikasi iOS.\r\n\r\n6. Kotlin 📱\r\nBahasa modern yang digunakan dalam pengembangan aplikasi Android.\r\n\r\n7. PHP 🌍\r\nBanyak digunakan dalam pengembangan website dinamis seperti WordPress.\r\n\r\n8. Ruby 💎\r\nMemiliki sintaks sederhana dan framework Ruby on Rails yang sangat populer.\r\n\r\n9. Go (Golang) 🚀\r\nBahasa dari Google yang cepat dan aman untuk pengembangan backend.\r\n\r\n10. Rust 🔥\r\nFokus pada keamanan dan performa tinggi, cocok untuk pengembangan sistem.\r\n\r\nKesimpulan\r\nJika kamu pemula, Python atau JavaScript adalah pilihan terbaik. Namun, sesuaikan pilihanmu dengan tujuan yang ingin dicapai!', '67b14548bb8f0.jpeg', 3, 'Dipublish', 1, 'Belajar coding, Bahasa pemrograman pemula, Cara memulai programming', 0),
(25, 'Tutorial Pembuatan Chatbot menggunakan OPENAI', '2025-06-01 11:20:12', 'Introduction\r\nEver wanted to create your own chatbot? This tutorial will guide you through the process using the OpenAI API with React, following a step-by-step approach.\r\n\r\nI’ve included all the necessary steps for regular users, from obtaining the API key to building the chatbot from scratch. I suggest you follow the instructions sequentially, without skipping any parts.\r\n\r\nStep 1 : API Key\r\nBegin by installing the OpenAI library to enable interaction with the API. In your terminal, use the following npm command to install the OpenAI library. Ensure you use the latest version available, which is 4.0.0 in this case.\r\n\r\nnpm install openai@^4.0.0\r\nNow, it’s time to obtain an API key. This key will permit you to make calls to ChatGPT through your interface and showcase the results directly from the OpenAI website. If you don’t already have an account, you’ll need to sign up on the OpenAI website. For those who already have an account, just log in.\r\n\r\nOnce you’ve logged in, you’ll be taken to the OpenAI platform. Click on your profile at the upper-right corner and choose `View API keys` from the drop-down menu.\r\n\r\n\r\nUpon clicking, you’ll be taken to the API keys page. To generate an API key, locate and select the Create new secret key button. You can provide a name for the key, if desired. After naming, click the Create secret key button. You should then copy the resulting secret key.\r\n\r\n\r\nRemember, you won’t have the option to retrieve or copy the complete API key at a later time. Therefore, it’s a good idea to save it in a text editor for future use. Additionally, avoid sharing or displaying the API key publicly to ensure its security.\r\n\r\nStep 2 : Creating your project\r\nNavigate to your project folder. Open the terminal within that folder and execute the following commands in your terminal to create your project:\r\n\r\nnpx create-react-app your-app-name\r\ncd your-app-name\r\nnpm start\r\nThis sets up your project. To preview your app, open http://localhost:3000/ in your web browser.\r\n\r\nStep 3 : Saving the API Key\r\nUsing a code editor like VSCode, open the project you’ve just created. Create a .env file (e.g., .env.local) in the root directory of your project. This file will store sensitive information, such as your API key. It\'s crucial to keep this file secure and private to prevent unauthorized access to your OpenAI resources.\r\n\r\nSave the secret API key you generated in the previous step using this format\r\n\r\nREACT_APP_OPEN_API_KEY=your-api-key\r\nReplace your-api-key with the actual key you generated. Take note that variable names in .env files for React applications should start with REACT_APP_ to be recognized by Create React App.\r\n\r\nImportant Security Reminder: Ensure that the .env file containing your API key is never committed to version control. This file may contain sensitive information, and exposing it publicly could lead to unauthorized access and potential misuse of your OpenAI resources.\r\n\r\nRestart Your Server\r\nRestart your development server every time you add or change a variable in the .env file. This ensures that the changes take effect, allowing your React application to access the updated environment variables.\r\n\r\nStep 4: Initial Code Setup\r\nNext, within the app.js file, remove all the existing code within the React component function. Your code should now look like this:\r\n\r\nimport \"./App.css\";\r\n\r\nfunction App() {\r\n  return <div></div>;\r\n}\r\n\r\nexport default App;\r\nNow, let’s create a function to request information from the API. To start, we need to retrieve the API key. In your app component, add the following code to access the API key from the .env.local file.\r\n\r\nfunction App() {\r\n  // Retrieve data from the .env file\r\n  const API_KEY = process.env.REACT_APP_OPEN_API_KEY;\r\n\r\n  // The rest of your code will be added here\r\n\r\n  return <div></div>;\r\n}\r\nStep 5: Understand OpenAI API Roles\r\nBefore we proceed, let’s discuss the roles assigned in the OpenAI API, and there are three of them:\r\n\r\nSystem Role: In the System Role, you define the primary prompt for the chatbot. For instance, if you input, “You are an assistant that speaks in the style of William Shakespeare,” the chatbot will respond in a Shakespearean manner. Another example is, “Summarize the user’s input in a concise manner,” instructing the chatbot to provide a brief summary of the user’s input. The beauty lies in the flexibility to customize the chatbot’s behavior according to your desires. In this tutorial, we’ll be creating a grammar-checking chatbot using the System Role.\r\nUser Role: The User Role represents the input provided by the user to the chatbot. This input is a crucial part of the conversation, influencing the chatbot’s responses.\r\nAssistant Role: Lastly, the Assistant Role pertains to the output generated by the chatbot, which is then presented to the user. This role encapsulates the responses, suggestions, or information that the chatbot provides based on the given input.\r\nFeel free to explore the possibilities and tailor the chatbot to suit your needs! Understanding and manipulating these roles offer you the flexibility to create a chatbot that aligns with your specific requirements and functionalities.\r\n\r\nStep 6: Create a State Variable\r\nLet’s kick off by creating a state variable using the useState hook. If you’re not sure how to use useState, you can check out the official documentation here. We’re going to set the initial system message as the starting point for useState.\r\n\r\nMake sure to include the import statement for useState from React. Here’s an example to get you started:\r\n\r\n// Importing useState\r\nimport { useState } from \"react\";\r\nimport \"./App.css\";\r\n\r\nfunction App() {\r\n // Your OpenAI API key\r\n const API_KEY = process.env.OPEN_API_KEY;\r\n// Setting the primary prompt as the initial state\r\n const [messages, setMessages] = useState([\r\n {\r\n role: \"system\",\r\n content:\r\n \"You\'re like a grammar-checking wizard, helping users fix grammar bloopers and jazz up their sentence structures.\",\r\n },\r\n ]);\r\n// rest of your code\r\n // …\r\n}\r\nNow we are ready to dive into our implementation.\r\n\r\nStep 7: Make API Requests\r\nFor making a call to the OpenAI API, the function appears like this:\r\n\r\nconst response = await fetch(\r\n  \"https://api.openai.com/v1/chat/completions\",\r\n  {\r\n    method: \"POST\",\r\n    headers: {\r\n      \"Content-Type\": \"application/json\",\r\n      Authorization: `Bearer ${API_KEY}`,\r\n    },\r\n    body: JSON.stringify({\r\n      model: \"gpt-3.5-turbo\",\r\n      // We\'ll later replace the content with user input\r\n      messages: [...messages, { \"role\": \"user\", \"content\": \"This is a test!\" }],\r\n      temperature: 0.7,\r\n    }),\r\n  }\r\n);\r\nUpon a successful call, you’ll receive a response that looks something like this:\r\n\r\n{\r\n  \"id\": \"chatcmpl-abc123\",\r\n  \"object\": \"chat.completion\",\r\n  \"created\": 1677858242,\r\n  \"model\": \"gpt-3.5-turbo-0613\",\r\n  \"usage\": {\r\n    \"prompt_tokens\": 13,\r\n    \"completion_tokens\": 7,\r\n    \"total_tokens\": 20\r\n  },\r\n  \"choices\": [\r\n    {\r\n      \"message\": {\r\n        \"role\": \"assistant\",\r\n        \"content\": \"\\n\\nThis is a test!\"\r\n      },\r\n      \"finish_reason\": \"stop\",\r\n      \"index\": 0\r\n    }\r\n  ]\r\n}\r\nYou can find more details about the complete response object here\r\n\r\nStep 8: Create the Chatbot Component\r\nLet’s now construct a basic chatbot component that captures user input and displays the corresponding output. The chatbot component is designed as follows:\r\n\r\nreturn (\r\n  <>\r\n    <div>\r\n      {messages.map((message, index) => (\r\n        <div key={index}>\r\n          <h3>{message.role}</h3>\r\n          <p>{message.content}</p>\r\n        </div>\r\n      ))}\r\n    </div>\r\n    <form>\r\n      <input\r\n        type=\"text\"\r\n        name=\"input\"\r\n        placeholder=\"Type your message...\"\r\n      />\r\n      <button type=\"submit\">\r\n        Send\r\n      </button>\r\n    </form>\r\n  </>\r\n);\r\nIn the provided code snippet, I’ve implemented a form to receive user input, complete with a submission button. Additionally, a container (div) renders the messages, with each message featuring a role and content displayed inside nested h3 and p elements, respectively.\r\n\r\nI haven’t applied any specific styling to the component; I’ll let you sprinkle your creative magic on that.\r\n\r\nNow, let’s establish a function to capture user input and store it in the messages array state variable that we created earlier. We\'ll also pass the input to the API call function. Modify the form tag as follows to receive user input and send it to the upcoming handleSendMessage function. Consider enhancing accessibility for users relying on screen readers by adding aria-label attributes to interactive elements.\r\n\r\n<form\r\n  onSubmit={(e) => {\r\n    e.preventDefault();\r\n    const input = e.target.input.value;\r\n    if (input.trim() !== \"\") {\r\n      handleSendMessage(input);\r\n      e.target.reset();\r\n    }\r\n  }}\r\naria-label=\"Chat Input Form\"\r\n>\r\nStep 9: Handle User Input\r\nNow, let’s implement the handleSendMessage function:\r\n\r\nconst handleSendMessage = (messageContent) => {\r\n  setMessages((prevMessages) => [\r\n    ...prevMessages,\r\n    { role: \"user\", content: messageContent },\r\n  ]);\r\n};\r\nThis function extracts the input from the form, adds it to the messages array, and assigns the role \"user\" to it.\r\n\r\nStep 10: Finalize API Calling Function\r\nLet’s finalize our API calling function. We’re introducing a new asynchronous function called chatData, which takes userMessage as an argument and invokes the fetch API function. Afterward, we validate the response\'s status, ensuring it\'s successful. If the response is indeed okay, we proceed by converting it into a JSON object. Subsequently, we utilize our state-changing function, setMessages, to incorporate the fetched message from responseData.choices[0].message.content. We label this message with the role \"assistant\", representing the final output from the chatbot.\r\n\r\nIn case the response is not okay, we implement an error handling mechanism, logging a message to the console indicating a failure in the Chat API request. Moreover, if the structure of responseData is not as expected, we log another message to the console, flagging it as an invalid structure. Finally, we catch any errors that may occur during the fetching of chat data, logging an appropriate message to the console.\r\n\r\nconst chatData = async (userMessage) => {\r\n  try {\r\n    const response = await fetch(\r\n      \"https://api.openai.com/v1/chat/completions\",\r\n      {\r\n        method: \"POST\",\r\n        headers: {\r\n          \"Content-Type\": \"application/json\",\r\n          Authorization: `Bearer ${API_KEY}`,\r\n        },\r\n        body: JSON.stringify({\r\n          model: \"gpt-3.5-turbo\",\r\n          messages: [...messages, { role: \"user\", content: userMessage }],\r\n          temperature: 0.7,\r\n        }),\r\n      }\r\n    );\r\n\r\n    if (!response.ok) {\r\n      throw new Error(\"Oops! Something went wrong while processing your request.\");\r\n    }\r\n\r\n    const responseData = await response.json();\r\n    setMessages((prevMessages) => [\r\n      ...prevMessages,\r\n      {\r\n        role: \"assistant\",\r\n        content: responseData.choices[0].message.content,\r\n      },\r\n    ]);\r\n  } catch (error) {\r\n    console.error(\"Error while fetching chat data:\", error);\r\n  }\r\n};\r\nAdjust the handleSendMessage function to invoke chatData and forward the input to it:\r\n\r\nconst handleSendMessage = (messageContent) => {\r\n  setMessages((prevMessages) => [\r\n    ...prevMessages,\r\n    { role: \"user\", content: messageContent },\r\n  ]);\r\n//invoke chatData\r\n  chatData(messageContent);\r\n};\r\nIf you’ve been following along, your chatbot should be doing well. But before we finish, let’s make it even better for users. We’ll add a feature to let users know when the chatbot is thinking.\r\n\r\nStep 11: Improve User Experience\r\nStart by introducing a new state variable called isTyping:\r\n\r\n// Indicates whether the chatbot is currently processing a message\r\nconst [isTyping, setIsTyping] = useState(false);\r\nNext, let’s tell the chatbot to act like it’s typing when it’s processing a message. In the handleSendMessage and chatData functions, set the isTyping state to true when the chatbot is doing its thing and false when it’s done:\r\n\r\nconst handleSendMessage = (messageContent) => {\r\n  // rest of your code...\r\n  setIsTyping(true);\r\n};\r\n\r\nconst chatData = async (userMessage) => {\r\n  // rest of your code...\r\n  const responseData = await response.json();\r\n  setIsTyping(false);\r\n  // rest of your code...\r\n} catch (error) {\r\n  console.error(\"Error while fetching chat data:\", error);\r\n  setIsTyping(false);\r\n}\r\nNow, you can show users a message when the chatbot is typing. Also, let’s use this the isTyping state to disable user input, preventing multiple requests that could potentially disrupt your chatbot.\r\n\r\n<>\r\n  <div>\r\n    {messages.map((message, index) => (\r\n      <div key={index}>\r\n        <h3>{message.role}</h3>\r\n        <p>{message.content}</p>\r\n      </div>\r\n    ))}\r\n    {isTyping && <p>Bot is typing...</p>}\r\n  </div>\r\n  <form\r\n    onSubmit={(e) => {\r\n      e.preventDefault();\r\n      const input = e.target.input.value;\r\n      if (input.trim() !== \"\") {\r\n        handleSendMessage(input);\r\n        e.target.reset();\r\n      }\r\n    }}\r\n  >\r\n    <input\r\n      type=\"text\"\r\n      name=\"input\"\r\n      placeholder=\"Type your message...\"\r\n      disabled={isTyping}\r\n    />\r\n    <button\r\n      type=\"submit\"\r\n      disabled={isTyping}\r\n    >\r\n      Send\r\n    </button>\r\n  </form>\r\n</>\r\nConclusion\r\nNow, your chatbot is ready to roll. Customize it as you like — add styles, change the system message, and more. I hope you enjoyed learning about it.', '683bd383e57a6.png', 8, 'Dipublish', 3, 'teknologi, programming, ai', 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Pemograman dan Pengembangan'),
(2, 'Keamanan Jaringan'),
(3, 'AI'),
(4, 'Teknologi dan inovasi'),
(5, 'Karir'),
(6, 'Infrastruktur');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `artikel_id` int NOT NULL,
  `isi` text NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tanggal` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UserId` int DEFAULT NULL,
  `guest_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `artikel_id`, `isi`, `nama`, `tanggal`, `UserId`, `guest_name`) VALUES
(45, 24, 'mantap bang novan', 'bintang', '2025-02-16 02:25:16', 2, NULL),
(46, 24, 'sangat bermanfaat', 'icikiwir', '2025-02-16 02:25:55', NULL, 'icikiwir'),
(47, 23, '<script>alert(\"Warning\");</script>', 'ets', '2025-02-18 01:07:46', NULL, 'ets'),
(48, 24, 'test named parameter', 'bintang12', '2025-03-05 03:49:01', 7, NULL),
(49, 24, 'asdasdas', 'bintang12', '2025-03-05 03:55:00', 7, NULL),
(50, 24, 'testt1', 'aku jaw4', '2025-03-05 04:07:53', NULL, 'aku jaw4'),
(51, 22, 'test', 'test', '2025-05-29 07:44:05', NULL, 'test'),
(52, 25, 'mantap palembang', 'bin1', '2025-06-01 04:27:28', 8, NULL),
(53, 25, 'sangat membantu', 'diaz', '2025-06-01 04:28:41', NULL, 'diaz');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserId` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserId`, `nama`, `email`, `password`, `role`) VALUES
(1, 'diaz', 'diaz@gmail.com', '$2y$10$OdK6SVtJS8jJ2n4EvQfI2OGel/72Cp.Kbft4Ito5tqGBx9FkxI0sm', 'user'),
(2, 'bintang', 'bintang@gmail.com', '$2y$10$b2ryhcSV0MLt1rXE7pvm4.AIfhK6LtRA315M9ZP8bdNnKmL.GR0wa', 'user'),
(3, 'novan', 'novan@gmail.com', '$2y$10$Cefh0HYO1x1DS3Qkr4B2Dehxu61ZSr3a.PK90qLFYtWbugjuQGofe', 'user'),
(4, 'aaa', 'a@gmail.com', '$2y$10$5z6LitYqZdXOKR4F6Rf21.9h2MAVQUtefY8MWFNkb7HD6j0GuRU/q', 'user'),
(5, 'bono', 'b@gmail.com', '$2y$10$Gm3uRm3BOqMtA99qQH10webO1mbPo5cQa5oIcnmraX1HjK7UPzT2C', 'user'),
(6, 'icikiwir', 'bintang1@gmail.com', '$2y$10$wrevGzhMj/ZoKFmS9dMrr.8Wp29k9UVkC/D0XnDks60hNgcjw/qJK', 'user'),
(7, 'bintang12', 'bintang12@gmail.com', '$2y$10$lG8tkdoJxKWg47tfZste7Outtn.j8ecuh6BVOFSLJ3eY50PiZKMMm', 'user'),
(8, 'bin1', 'bin1@gmail.com', '$2y$10$Njey2CmsXvFggBZdSKQtGOTVoHfnmk1.mS7JfVs.0KjTDUQrEJaMS', 'user'),
(9, 'bintang123', 'bintang1234@gmail.com', '$2y$10$FRGn7PIh4SBhI.Xwl7m9ve0abWzcvFGsK98w9PfoiCZRD83vFycl2', 'user'),
(10, 'diazz', 'diazgeming@gmail.com', '$2y$10$CHtRtqOmpMXifP67QP4YRu9RlETO8EUrEbO5MpTIGFHU3TC/mkG4m', 'user'),
(11, 'admin', 'admin123@gmail.com', '$2y$10$ke5aJQVJlBUoZ6HdZbqdf.HeAOB42wQNC5AxP5/rAe969HeOSx8f2', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article_keywords`
--
ALTER TABLE `article_keywords`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artikel_id` (`artikel_id`),
  ADD KEY `keyword` (`keyword`);

--
-- Indexes for table `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`UserId`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artikel_id` (`artikel_id`),
  ADD KEY `fk_user_id2` (`UserId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article_keywords`
--
ALTER TABLE `article_keywords`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `article_keywords`
--
ALTER TABLE `article_keywords`
  ADD CONSTRAINT `article_keywords_ibfk_1` FOREIGN KEY (`artikel_id`) REFERENCES `artikel` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `artikel`
--
ALTER TABLE `artikel`
  ADD CONSTRAINT `artikel_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`UserId`) REFERENCES `user` (`UserId`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`artikel_id`) REFERENCES `artikel` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_id2` FOREIGN KEY (`UserId`) REFERENCES `user` (`UserId`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
