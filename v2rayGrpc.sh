#!/usr/bin/env bash
#########
### 用法： ./v2rayGrpc.sh ../../../../../../../../grpc/bins/opt/grpc_php_plugin
#########

cd vendor/swoole/etcd-client/src/Grpc/Proto
git clone https://github.com/v2ray/v2ray-core.git && cd v2ray-core

#因为grpc没有专门的PHP命名空间或者包名，所以需要把v2ray.com/core/去掉，不然会无法导入其他protobuf文件
sed -ir 's:import "v2ray.com/core/:import ":' $(find . -type f -name "*.proto")

#生成可在Swoole框架下使用的Grpc库，需指定grpc_php_plugin的相对路径
../../../../tools/generator \
--plugin=protoc-gen-grpc=`pwd`/$1 \
--proto_path=./ --php_out=./../../../../src/Grpc \
--grpc_out=./../../../../src/Grpc \
$(find . -type f -name "*.proto")

cd ../../src

#修正GPBMetadata的名称空间
sed -i '' 's:GPBMetadata:V2ray\\GPBMetadata:' $(find . -type f -name "*.php")

composer update
