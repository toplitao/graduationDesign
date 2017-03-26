<?php
namespace app;
    class sftp
    {
        // 初始配置为NULL
        private $config = [
            'host' => '150.95.154.245',      //  ftp地址
            'user' => 'foo',
            'port' => '2222',
            'password' => '123',
            'pubkey_path' => null,   // 公钥的存储地址
            'privkey_path' => null,          // 私钥的存储地址
        ];
        // 连接为NULL
        private $conn = NULL;
        // 是否使用秘钥登陆
        private $use_pubkey_file = false;

        // 初始化
        public function init($config)
        {
            $this->config = $config;
        }

        // 连接ssh ,连接有两种方式
        // (1) 使用密码
        // (2) 使用秘钥
        public function connect()
        {
            $methods['hostkey'] = $this->use_pubkey_file ? 'ssh-rsa' : [];
            $this->coon = ssh2_connect($this->config['host'], $this->config['port'], $methods);
            //(1) 使用秘钥的时候
            if ($this->use_pubkey_file) {
                // 用户认证协议
                $rc = ssh2_auth_pubkey_file(
                    $this->conn,
                    $this->config['user'],
                    $this->config['pubkey_file'],
                    $this->config['privkey_file'],
                    $this->config['passphrase']
                );
                //(2) 使用登陆用户名字和登陆密码
            } else {
                $rc = ssh2_auth_password($this->conn, $this->config['user'], $this->config['password']);
            }
            return $rc;
        }


        // 传输数据 传输层协议,获得数据
        public function download($remote, $local)
        {
            return ssh2_scp_recv($this->conn, $remote, $local);
        }

        //传输数据 传输层协议,写入ftp服务器数据
        public function upload($remote, $local, $file_mode = 0777)
        {
            return ssh2_scp_send($this->conn, $local, $remote, $file_mode);
        }

        // 删除文件
        public function remove($remote)
        {
            $sftp = ssh2_sftp($this->conn);
            $rc = false;
            if (is_dir("ssh2.sftp://{$sftp}/{$remote}")) {
                $rc = false;
                // ssh 删除文件夹
                $rc = ssh2_sftp_rmdir($sftp, $remote);
            } else {
                // 删除文件
                $rc = ssh2_sftp_unlink($sftp, $remote);
            }
            return $rc;
        }
    }