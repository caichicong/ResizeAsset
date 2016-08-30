# config.json示例

```   
    {
        "images" : [
            { "width2x" : 20, "width3x" : 40, "name" : "play.png"},
            { "width2x" : 100, "width3x" : 200, "name" : "test.jpg"},
            { "width2x" : 100, "width3x" : 200, "name" : "sound3.gif"}
        ]  
    }
```

width2x 代表2倍图宽度

width3x 代表3倍图宽度

# 用法

```
chmod a+x resize.php
./resize.php
```

生成的图片会保存在out文件夹里面