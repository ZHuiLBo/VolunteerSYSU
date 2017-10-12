#项目目录结构及说明：
├─Home 前台应用文件夹
├───├─Common 项目公共文件目录
├───├─Conf 项目配置目录
├───├─Lang 项目语言目录
├───├─Lib 项目类库目录
├───│  ├─Action Action类库目录  （我们的controller或者说action放在这）
├───│  ├─Behavior 行为类库目录
├───│  ├─Model 模型类库目录  （如果有Model类，那就放在这）
├───│  └─Widget Widget类库目录
├───├─Runtime 项目运行时目录
├───│  ├─Cache 模板缓存目录
├───│  ├─Data 数据缓存目录
├───│  ├─Logs 日志文件目录
├───│  └─Temp 临时缓存目录
├───└─Tpl 项目模板目录  （我们的html放在这）
├─Public 公共文件夹
├───├─asset （我们的html用的css，js什么的放在这了）
├─ThinkPHP 核心文件，不要动它
├─index.php 项目入口文件