<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Laravel 10 FaleMais API</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
                    body .content .php-example code { display: none; }
                    body .content .python-example code { display: none; }
            </style>

    <script>
        var tryItOutBaseUrl = "http://localhost";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-4.35.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-4.35.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;,&quot;php&quot;,&quot;python&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                                            <button type="button" class="lang-button" data-language-name="php">php</button>
                                            <button type="button" class="lang-button" data-language-name="python">python</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-call-prices" class="tocify-header">
                <li class="tocify-item level-1" data-unique="call-prices">
                    <a href="#call-prices">Call Prices</a>
                </li>
                                    <ul id="tocify-subheader-call-prices" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="call-prices-POSTapi-call-prices-simulate">
                                <a href="#call-prices-POSTapi-call-prices-simulate">Simulates a call price</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-endpoints" class="tocify-header">
                <li class="tocify-item level-1" data-unique="endpoints">
                    <a href="#endpoints">Endpoints</a>
                </li>
                                    <ul id="tocify-subheader-endpoints" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="endpoints-POSTapi-auth-login">
                                <a href="#endpoints-POSTapi-auth-login">POST api/auth/login</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-auth-me">
                                <a href="#endpoints-GETapi-auth-me">GET api/auth/me</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-plans">
                                <a href="#endpoints-GETapi-plans">GET api/plans</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-fares" class="tocify-header">
                <li class="tocify-item level-1" data-unique="fares">
                    <a href="#fares">Fares</a>
                </li>
                                    <ul id="tocify-subheader-fares" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="fares-GETapi-fares">
                                <a href="#fares-GETapi-fares">List fares</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                        <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: April 9, 2024</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<p>API that allows the simulation of call prices following plan`s rules proposed.</p>
<aside>
    <strong>Base URL</strong>: <code>{{config("app.url")}}:{{config("app.port")}}</code>
</aside>
<p>This documentation will provide all the information you need to work with our API.</p>
<aside>
As you scroll, you'll see code examples for working with the API in the available programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).
</aside>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>To authenticate requests, include an <strong><code>Authorization</code></strong> header with the value <strong><code>"Bearer {YOUR_ACCESS_TOKEN}"</code></strong>.</p>
<p>All authenticated endpoints are marked with a <code>requires authentication</code> badge in the documentation below.</p>
<p>You can retrieve your token by visiting your dashboard and clicking <b>Generate API token</b>.</p>

        <h1 id="call-prices">Call Prices</h1>

    <p>Endpoints for managing call prices calculation</p>

                                <h2 id="call-prices-POSTapi-call-prices-simulate">Simulates a call price</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>This endpoint lets you simulate a call price.</p>

<span id="example-requests-POSTapi-call-prices-simulate">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "{{config("app.url")}}:{{config("app.port")}}/api/call-prices/simulate" \
    --header "Authorization: Bearer {YOUR_ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"ddd_origin\": \"011\",
    \"ddd_destination\": \"017\",
    \"call_minutes\": 80,
    \"plan_id\": 2
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "{{config("app.url")}}:{{config("app.port")}}/api/call-prices/simulate"
);

const headers = {
    "Authorization": "Bearer {YOUR_ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ddd_origin": "011",
    "ddd_destination": "017",
    "call_minutes": 80,
    "plan_id": 2
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = '{{config("app.url")}}:{{config("app.port")}}/api/call-prices/simulate';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {YOUR_ACCESS_TOKEN}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'ddd_origin' =&gt; '011',
            'ddd_destination' =&gt; '017',
            'call_minutes' =&gt; 80,
            'plan_id' =&gt; 2,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = '{{config("app.url")}}:{{config("app.port")}}/api/call-prices/simulate'
payload = {
    "ddd_origin": "011",
    "ddd_destination": "017",
    "call_minutes": 80,
    "plan_id": 2
}
headers = {
  'Authorization': 'Bearer {YOUR_ACCESS_TOKEN}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre></div>

</span>

<span id="example-responses-POSTapi-call-prices-simulate">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;price_with_plan&quot;: 167.2,
        &quot;price_without_plan&quot;: 380
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (400, fare not found):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Cannot proceed. Could no find a fare with the ddd origin and ddd destination provided.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (400, plan not found):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Cannot proceed. Could no find a plan with the id provided.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (500, unexpected error):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Internal Server Error.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-call-prices-simulate" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-call-prices-simulate"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-call-prices-simulate"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-call-prices-simulate" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-call-prices-simulate">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-call-prices-simulate" data-method="POST"
      data-path="api/call-prices/simulate"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-call-prices-simulate', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-call-prices-simulate"
                    onclick="tryItOut('POSTapi-call-prices-simulate');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-call-prices-simulate"
                    onclick="cancelTryOut('POSTapi-call-prices-simulate');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-call-prices-simulate"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/call-prices/simulate</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-call-prices-simulate"
               value="Bearer {YOUR_ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-call-prices-simulate"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-call-prices-simulate"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ddd_origin</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ddd_origin"                data-endpoint="POSTapi-call-prices-simulate"
               value="011"
               data-component="body">
    <br>
<p>The DDD for the origin of the call. Must be at least 3 characters. Must not be greater than 3 characters. Example: <code>011</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ddd_destination</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ddd_destination"                data-endpoint="POSTapi-call-prices-simulate"
               value="017"
               data-component="body">
    <br>
<p>The DDD for the destination of the call. Must be at least 3 characters. Must not be greater than 3 characters. Example: <code>017</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>call_minutes</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="call_minutes"                data-endpoint="POSTapi-call-prices-simulate"
               value="80"
               data-component="body">
    <br>
<p>The total duration time of the call in minutes. The call minutes field must be greater than 0. Example: <code>80</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>plan_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="plan_id"                data-endpoint="POSTapi-call-prices-simulate"
               value="2"
               data-component="body">
    <br>
<p>The plan ot be used on the simulation. The plan id field must be greater than 0. Example: <code>2</code></p>
        </div>
        </form>

    <h3>Response</h3>
    <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
    <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>price_with_plan</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
<br>
<p>The call price if calculate using one of the plans.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>price_without_plan</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
<br>
<p>The call price if calculate without using a plan.</p>
        </div>
                    <h1 id="endpoints">Endpoints</h1>

    

                                <h2 id="endpoints-POSTapi-auth-login">POST api/auth/login</h2>

<p>
</p>



<span id="example-requests-POSTapi-auth-login">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "{{config("app.url")}}:{{config("app.port")}}/api/auth/login" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"email\": \"test@test.com\",
    \"password\": \"LfMJvB5b9xZbF76Q4tFT\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "{{config("app.url")}}:{{config("app.port")}}/api/auth/login"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "test@test.com",
    "password": "LfMJvB5b9xZbF76Q4tFT"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = '{{config("app.url")}}:{{config("app.port")}}/api/auth/login';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'email' =&gt; 'test@test.com',
            'password' =&gt; 'LfMJvB5b9xZbF76Q4tFT',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = '{{config("app.url")}}:{{config("app.port")}}/api/auth/login'
payload = {
    "email": "test@test.com",
    "password": "LfMJvB5b9xZbF76Q4tFT"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre></div>

</span>

<span id="example-responses-POSTapi-auth-login">
</span>
<span id="execution-results-POSTapi-auth-login" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-auth-login"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-auth-login"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-auth-login" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-auth-login">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-auth-login" data-method="POST"
      data-path="api/auth/login"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-auth-login', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-auth-login"
                    onclick="tryItOut('POSTapi-auth-login');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-auth-login"
                    onclick="cancelTryOut('POSTapi-auth-login');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-auth-login"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/auth/login</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-auth-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-auth-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-auth-login"
               value="test@test.com"
               data-component="body">
    <br>
<p>The e-mail of the user. Must be a valid email address. Must be at least 6 characters. Must not be greater than 70 characters. Example: <code>test@test.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-auth-login"
               value="LfMJvB5b9xZbF76Q4tFT"
               data-component="body">
    <br>
<p>The password of the user. Must be at least 6 characters. Example: <code>LfMJvB5b9xZbF76Q4tFT</code></p>
        </div>
        </form>

                    <h2 id="endpoints-GETapi-auth-me">GET api/auth/me</h2>

<p>
</p>



<span id="example-requests-GETapi-auth-me">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "{{config("app.url")}}:{{config("app.port")}}/api/auth/me" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "{{config("app.url")}}:{{config("app.port")}}/api/auth/me"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = '{{config("app.url")}}:{{config("app.port")}}/api/auth/me';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = '{{config("app.url")}}:{{config("app.port")}}/api/auth/me'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>

</span>

<span id="example-responses-GETapi-auth-me">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-auth-me" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-auth-me"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-auth-me"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-auth-me" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-auth-me">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-auth-me" data-method="GET"
      data-path="api/auth/me"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-auth-me', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-auth-me"
                    onclick="tryItOut('GETapi-auth-me');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-auth-me"
                    onclick="cancelTryOut('GETapi-auth-me');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-auth-me"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/auth/me</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-auth-me"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-auth-me"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-plans">GET api/plans</h2>

<p>
</p>



<span id="example-requests-GETapi-plans">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "{{config("app.url")}}:{{config("app.port")}}/api/plans" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "{{config("app.url")}}:{{config("app.port")}}/api/plans"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = '{{config("app.url")}}:{{config("app.port")}}/api/plans';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = '{{config("app.url")}}:{{config("app.port")}}/api/plans'
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>

</span>

<span id="example-responses-GETapi-plans">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-plans" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-plans"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-plans"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-plans" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-plans">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-plans" data-method="GET"
      data-path="api/plans"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-plans', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-plans"
                    onclick="tryItOut('GETapi-plans');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-plans"
                    onclick="cancelTryOut('GETapi-plans');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-plans"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/plans</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-plans"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-plans"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                <h1 id="fares">Fares</h1>

    <p>Endpoints for managing fares</p>

                                <h2 id="fares-GETapi-fares">List fares</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>This endpoint lets you get a list of fares.</p>

<span id="example-requests-GETapi-fares">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "{{config("app.url")}}:{{config("app.port")}}/api/fares" \
    --header "Authorization: Bearer {YOUR_ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "{{config("app.url")}}:{{config("app.port")}}/api/fares"
);

const headers = {
    "Authorization": "Bearer {YOUR_ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = '{{config("app.url")}}:{{config("app.port")}}/api/fares';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {YOUR_ACCESS_TOKEN}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = '{{config("app.url")}}:{{config("app.port")}}/api/fares'
headers = {
  'Authorization': 'Bearer {YOUR_ACCESS_TOKEN}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>

</span>

<span id="example-responses-GETapi-fares">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
     &quot;data&quot;: [
         {
             &quot;id&quot;: 1,
             &quot;ddd_origin&quot;: &quot;011&quot;,
             &quot;ddd_destination&quot;: &quot;016&quot;,
             &quot;price_per_minute&quot;: 1.9
         },
         {
             &quot;id&quot;: 2,
             &quot;ddd_origin&quot;: &quot;016&quot;,
             &quot;ddd_destination&quot;: &quot;011&quot;,
             &quot;price_per_minute&quot;: 2.9
         },
         {
             &quot;id&quot;: 3,
             &quot;ddd_origin&quot;: &quot;011&quot;,
             &quot;ddd_destination&quot;: &quot;017&quot;,
             &quot;price_per_minute&quot;: 1.7
         },
     ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (500, unexpected error):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Internal Server Error.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-fares" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-fares"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-fares"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-fares" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-fares">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-fares" data-method="GET"
      data-path="api/fares"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-fares', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-fares"
                    onclick="tryItOut('GETapi-fares');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-fares"
                    onclick="cancelTryOut('GETapi-fares');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-fares"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/fares</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-fares"
               value="Bearer {YOUR_ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-fares"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-fares"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

    <h3>Response</h3>
    <h4 class="fancy-heading-panel"><b>Response Fields</b></h4>
    <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
<br>
<p>The identifier of the fare.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ddd_origin</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
<br>
<p>The DDD for the origin of the call.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ddd_destination</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
<br>
<p>The DDD for the destination of the call.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>price_per_minute</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
<br>
<p>The price per minute of the call.</p>
        </div>
                

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                                                        <button type="button" class="lang-button" data-language-name="php">php</button>
                                                        <button type="button" class="lang-button" data-language-name="python">python</button>
                            </div>
            </div>
</div>
</body>
</html>
