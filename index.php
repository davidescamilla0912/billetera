<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración Billetera</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script>
</head>
<body>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cartera Virtual</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e8f5e9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        h1, h2 {
            color: #2e7d32;
            text-align: center;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #1b5e20;
        }
        input, select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #4caf50;
            border-radius: 4px;
        }
        button {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #45a049;
        }
        .toggle-form {
            text-align: center;
            margin-top: 1rem;
        }
        .toggle-form a {
            color: #2e7d32;
            text-decoration: none;
        }
        .wallet-functions {
            display: none;
        }
        .balance {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 1rem;
            color: #2e7d32;
        }
    </style>
</head>
<body>
    <div class="container">
        <div id="login-register">
            <h1>Cartera Virtual</h1>
            <div id="login-form">
                <h2>Iniciar Sesión</h2>
                <form id="login">
                    <div class="form-group">
                        <label for="login-email">Email:</label>
                        <input type="email" id="login-email" required>
                    </div>
                    <div class="form-group">
                        <label for="login-password">Contraseña:</label>
                        <input type="password" id="login-password" required>
                    </div>
                    <button type="submit">Iniciar Sesión</button>
                </form>
                <div class="toggle-form">
                    <a href="#" id="show-register">¿No tienes una cuenta? Regístrate</a>
                </div>
            </div>
            <div id="register-form" style="display: none;">
                <h2>Registro</h2>
                <form id="register">
                    <div class="form-group">
                        <label for="register-id">Identificación:</label>
                        <input type="text" id="register-id" required>
                    </div>
                    <div class="form-group">
                        <label for="register-name">Nombre:</label>
                        <input type="text" id="register-name" required>
                    </div>
                    <div class="form-group">
                        <label for="register-email">Email:</label>
                        <input type="email" id="register-email" required>
                    </div>
                    <div class="form-group">
                        <label for="register-phone">Teléfono:</label>
                        <input type="tel" id="register-phone" required>
                    </div>
                    <div class="form-group">
                        <label for="register-password">Contraseña:</label>
                        <input type="password" id="register-password" required>
                    </div>
                    <button type="submit">Registrarse</button>
                </form>
                <div class="toggle-form">
                    <a href="#" id="show-login">¿Ya tienes una cuenta? Inicia sesión</a>
                </div>
            </div>
        </div>
        <div id="wallet-functions" class="wallet-functions">
            <h2>Mi Cartera</h2>
            <div class="balance">Saldo: $<span id="balance">0.00</span></div>
            <div class="form-group">
                <label for="transaction-type">Tipo de Transacción:</label>
                <select id="transaction-type">
                    <option value="deposit">Depósito</option>
                    <option value="withdraw">Retiro</option>
                    <option value="transfer">Transferencia</option>
                    <option value="payment">Pago de Servicio</option>
                    <option value="recharge">Recarga Móvil</option>
                </select>
            </div>
            <div class="form-group">
                <label for="amount">Monto:</label>
                <input type="number" id="amount" min="0" step="0.01" required>
            </div>
            <div class="form-group" id="destination-account-group" style="display: none;">
                <label for="destination-account">Cuenta Destino:</label>
                <input type="text" id="destination-account">
            </div>
            <div class="form-group" id="service-type-group" style="display: none;">
                <label for="service-type">Tipo de Servicio:</label>
                <select id="service-type">
                    <option value="Luz">Luz</option>
                    <option value="Agua">Agua</option>
                    <option value="Gas">Gas</option>
                    <option value="Telefonía">Telefonía</option>
                    <option value="Internet">Internet</option>
                    <option value="TV">TV</option>
                    <option value="Otros">Otros</option>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Descripción:</label>
                <input type="text" id="description" required>
            </div>
            <button id="perform-transaction">Realizar Transacción</button>
            <button id="logout" style="margin-top: 1rem; background-color: #f44336;">Cerrar Sesión</button>
        </div>
    </div>
    <script>
        // Simulación de base de datos
        let users = [];
        let currentUser = null;
        let transactions = [];

        // Elementos DOM
        const loginRegisterDiv = document.getElementById('login-register');
        const walletFunctionsDiv = document.getElementById('wallet-functions');
        const loginForm = document.getElementById('login-form');
        const registerForm = document.getElementById('register-form');
        const showRegisterLink = document.getElementById('show-register');
        const showLoginLink = document.getElementById('show-login');
        const balanceSpan = document.getElementById('balance');
        const transactionTypeSelect = document.getElementById('transaction-type');
        const destinationAccountGroup = document.getElementById('destination-account-group');
        const serviceTypeGroup = document.getElementById('service-type-group');
        const performTransactionButton = document.getElementById('perform-transaction');
        const logoutButton = document.getElementById('logout');

        // Event Listeners
        showRegisterLink.addEventListener('click', () => {
            loginForm.style.display = 'none';
            registerForm.style.display = 'block';
        });

        showLoginLink.addEventListener('click', () => {
            registerForm.style.display = 'none';
            loginForm.style.display = 'block';
        });

        document.getElementById('login').addEventListener('submit', (e) => {
            e.preventDefault();
            const email = document.getElementById('login-email').value;
            const password = document.getElementById('login-password').value;
            login(email, password);
        });

        document.getElementById('register').addEventListener('submit', (e) => {
            e.preventDefault();
            const id = document.getElementById('register-id').value;
            const name = document.getElementById('register-name').value;
            const email = document.getElementById('register-email').value;
            const phone = document.getElementById('register-phone').value;
            const password = document.getElementById('register-password').value;
            register(id, name, email, phone, password);
        });

        transactionTypeSelect.addEventListener('change', () => {
            const transactionType = transactionTypeSelect.value;
            destinationAccountGroup.style.display = transactionType === 'transfer' ? 'block' : 'none';
            serviceTypeGroup.style.display = ['payment', 'recharge'].includes(transactionType) ? 'block' : 'none';
        });

        performTransactionButton.addEventListener('click', performTransaction);
        logoutButton.addEventListener('click', logout);

        // Funciones
        function login(email, password) {
            const user = users.find(u => u.email === email && u.password === password);
            if (user) {
                currentUser = user;
                showWalletFunctions();
                updateBalance();
            } else {
                alert('Email o contraseña incorrectos');
            }
        }

        function register(id, name, email, phone, password) {
            if (users.some(u => u.email === email)) {
                alert('El email ya está registrado');
                return;
            }
            const newUser = { id, name, email, phone, password, balance: 0 };
            users.push(newUser);
            alert('Registro exitoso. Por favor, inicia sesión.');
            showLoginLink.click();
        }

        function showWalletFunctions() {
            loginRegisterDiv.style.display = 'none';
            walletFunctionsDiv.style.display = 'block';
        }

        function updateBalance() {
            balanceSpan.textContent = currentUser.balance.toFixed(2);
        }

        function performTransaction() {
            const type = transactionTypeSelect.value;
            const amount = parseFloat(document.getElementById('amount').value);
            const description = document.getElementById('description').value;

            if (isNaN(amount) || amount <= 0) {
                alert('Por favor, ingrese un monto válido');
                return;
            }

            switch (type) {
                case 'deposit':
                    currentUser.balance += amount;
                    break;
                case 'withdraw':
                    if (currentUser.balance < amount) {
                        alert('Saldo insuficiente');
                        return;
                    }
                    currentUser.balance -= amount;
                    break;
                case 'transfer':
                    const destinationAccount = document.getElementById('destination-account').value;
                    if (currentUser.balance < amount) {
                        alert('Saldo insuficiente');
                        return;
                    }
                    currentUser.balance -= amount;
                    
                    break;
                case 'payment':
                case 'recharge':
                    if (currentUser.balance < amount) {
                        alert('Saldo insuficiente');
                        return;
                    }
                    currentUser.balance -= amount;
                    break;
            }

            const transaction = {
                type,
                amount,
                description,
                date: new Date(),
                serviceType: type === 'payment' ? document.getElementById('service-type').value : null
            };
            transactions.push(transaction);

            updateBalance();
            alert('Transacción realizada con éxito');
        }

        function logout() {
            currentUser = null;
            loginRegisterDiv.style.display = 'block';
            walletFunctionsDiv.style.display = 'none';
            document.getElementById('login-form').reset();
            document.getElementById('register-form').reset();
        }
    </script>
</body>
</html>
