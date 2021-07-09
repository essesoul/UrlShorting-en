<?php require_once "header.php"; ?>
<div class="mdui-container doc-container">
    <div class="mdui-typo">
        <h2>Help</h2>
        1. Enter the short domain, please add http(s)://<br />
        2. Please manually encode the Chinese domain name with Punycode before using<br />
        3. The URL supports up to 1000 characters<br />
        4. The longest support for the secret language is 3000 characters<br />
        5. Manually fill in the short field and password as optional items<br />
        6. Password limit 2-20 digits (digital password combination) / short domain limit input <?php echo $pass ?> digits<br />
    </div>
</div>
<div class="mdui-container doc-container">
    <div class="mdui-typo">
        <h2>Api interface</h2>
        <div class="mdui-table-fluid">
            <table class="mdui-table mdui-table-hoverable">
                <tbody>
                    <tr>
                        <td>interface address</td>
                        <td>
                            <?php echo $url ?>api.php</td>
                    </tr>
                    <tr>
                        <td>Notice</td>
                        <td>Please use post to access Api</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mdui-table-fluid">
            <table class="mdui-table mdui-table-hoverable">
                <thead>
                    <tr>
                        <th>Parameter Name</th>
                        <th>Meaning</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>url</td>
                        <td>URLs that need to be shortened (prior to passphrases)</td>
                    </tr>
                    <tr>
                        <td>message</td>
                        <td>Secret words that need to be shortened</td>
                    </tr>
                    <tr>
                        <td>shorturl</td>
                        <td>Custom short domain (optional)</td>
                    </tr>
                    <tr>
                        <td>passwd</td>
                        <td>Encryption password (optional)</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mdui-table-fluid">
            <table class="mdui-table mdui-table-hoverable">
                <thead>
                    <tr>
                        <th>Return Value(json)</th>
                        <th>Meaning</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>code</td>
                        <td>Status code, see the table below</td>
                    </tr>
                    <tr>
                        <td>shorturl</td>
                        <td>The generated short URL will only be returned when the code is 200</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mdui-container doc-container">
            <div class="mdui-typo">
                <h2>Status code interpretation</h2>
                <div class="mdui-table-fluid">
                    <table class="mdui-table mdui-table-hoverable">
                        <thead>
                            <tr>
                                <th>Status Code</th>
                                <th>Meaning</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>200</td>
                                <td>Success</td>
                            </tr>
                            <tr>
                                <td>1002</td>
                                <td>Your IP or short domain is blocked</td>
                            </tr>
                            <tr>
                                <td>1001</td>
                                <td>Illegal input</td>
                            </tr>
                            <tr>
                                <td>2001/2002</td>
                                <td>Illegal custom short domain</td>
                            </tr>
                            <tr>
                                <td>2003</td>
                                <td>Custom short domain has been used</td>
                            </tr>
                            <tr>
                                <td>3001/3002</td>
                                <td>Illegal password</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once "footer.php"; ?>