<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Tester</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 24px; background: #f4f7fb; }
        label { display: block; margin-top: 16px; font-weight: bold; }
        textarea, input, select { width: 100%; padding: 10px; margin-top: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 6px; }
        button { margin-top: 12px; padding: 10px 16px; cursor: pointer; border: none; border-radius: 6px; background: #1d4ed8; color: white; }
        button.secondary { background: #334155; }
        .row { display: flex; gap: 12px; flex-wrap: wrap; }
        .card { border: 1px solid #ddd; padding: 18px; border-radius: 12px; background: white; margin-top: 20px; }
        .output { white-space: pre-wrap; background: #0f172a; color: #e2e8f0; padding: 16px; min-height: 180px; overflow: auto; border-radius: 8px; }
        .section { margin-top: 24px; }
    </style>
</head>
<body>
    <h1>API Tester</h1>
    <p>Halaman ini memungkinkan kamu login API dan menjalankan request <strong>POST</strong>, <strong>PUT</strong>, atau <strong>DELETE</strong> ke <code>/api/category</code> dalam satu halaman.</p>

    <div class="card section">
        <h2>Login API</h2>
        <label for="loginEmail">Email</label>
        <input id="loginEmail" type="email" placeholder="email@example.com" value="test@example.com" />

        <label for="loginPassword">Password</label>
        <input id="loginPassword" type="password" placeholder="password" value="password" />

        <button id="getToken">Dapatkan Token</button>
        <div id="loginResult" class="output">Login response akan muncul di sini.</div>
    </div>

    <div class="card section">
        <h2>Request API</h2>
        <label for="token">Bearer Token</label>
        <input id="token" type="text" placeholder="Masukkan token di sini atau gunakan tombol login" />

        <label for="endpoint">Endpoint</label>
        <select id="endpoint">
            <option value="/api/category">POST /api/category</option>
            <option value="/api/category/1">PUT /api/category/1</option>
            <option value="/api/category/1">DELETE /api/category/1</option>
        </select>

        <label for="method">Method</label>
        <select id="method">
            <option value="POST">POST</option>
            <option value="PUT">PUT</option>
            <option value="DELETE">DELETE</option>
        </select>

        <label for="body">Request Body (JSON)</label>
        <textarea id="body" rows="8">{
    "product_id": 3,
    "name": "Electronics"
}</textarea>

        <div class="row">
            <button id="sendRequest">Send Request</button>
            <button id="clearToken" type="button" class="secondary">Clear Token</button>
        </div>
    </div>

    <div class="card section">
        <h2>Response</h2>
        <div id="response" class="output">Ready</div>
    </div>

    <script>
        const tokenInput = document.getElementById('token');
        const endpointInput = document.getElementById('endpoint');
        const methodInput = document.getElementById('method');
        const bodyInput = document.getElementById('body');
        const responseOutput = document.getElementById('response');
        const sendRequestButton = document.getElementById('sendRequest');
        const loginEmail = document.getElementById('loginEmail');
        const loginPassword = document.getElementById('loginPassword');
        const getTokenButton = document.getElementById('getToken');
        const loginResult = document.getElementById('loginResult');
        const clearTokenButton = document.getElementById('clearToken');

        getTokenButton.addEventListener('click', async () => {
            const email = loginEmail.value.trim();
            const password = loginPassword.value.trim();

            if (!email || !password) {
                loginResult.textContent = 'Email dan password harus diisi.';
                return;
            }

            loginResult.textContent = 'Mengambil token...';

            try {
                const response = await fetch('/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ email, password })
                });

                const data = await response.json();
                loginResult.textContent = `Status: ${response.status} ${response.statusText}\n\n${JSON.stringify(data, null, 2)}`;

                if (response.ok && data.access_token) {
                    tokenInput.value = data.access_token;
                }
            } catch (error) {
                loginResult.textContent = 'Error login: ' + error.message;
            }
        });

        sendRequestButton.addEventListener('click', async () => {
            const url = endpointInput.value;
            const method = methodInput.value;
            const token = tokenInput.value.trim();
            let jsonBody = null;

            if (method !== 'DELETE') {
                try {
                    jsonBody = JSON.parse(bodyInput.value);
                } catch (error) {
                    responseOutput.textContent = 'JSON body tidak valid. Perbaiki JSON terlebih dahulu.';
                    return;
                }
            }

            const headers = {
                'Content-Type': 'application/json'
            };
            if (token) {
                headers['Authorization'] = 'Bearer ' + token;
            }

            responseOutput.textContent = 'Mengirim request...';

            try {
                const response = await fetch(url, {
                    method,
                    headers,
                    body: method === 'DELETE' ? null : JSON.stringify(jsonBody)
                });
                const text = await response.text();
                responseOutput.textContent = `Status: ${response.status} ${response.statusText}\n\n${text}`;
            } catch (error) {
                responseOutput.textContent = 'Error: ' + error.message;
            }
        });

        clearTokenButton.addEventListener('click', () => {
            tokenInput.value = '';
            responseOutput.textContent = 'Token dibersihkan.';
        });
    </script>
</body>
</html>
