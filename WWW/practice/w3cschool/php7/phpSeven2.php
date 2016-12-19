 <?php
class A {
    private $x = 1;
}

// PHP 7 之前版本定义闭包函数代码
$getXCB = function() {
    return $this->x;
};

// 闭包函数绑定到类 A 上
$getX = $getXCB->bindTo(new A, 'A'); 

echo $getX();
print(PHP_EOL);

// PHP 7+ 代码
$getX = function() {
    return $this->x;
};
echo $getX->call(new A);
?> 