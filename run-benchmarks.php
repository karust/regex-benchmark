<?php

const PATTERNS_COUNT = 3;

const RUN_TIMES = 10;

const BUILDS = [
    'Go Rure'      => 'cd go/rure && cargo build --release --manifest-path /regex/regex-capi/Cargo.toml && export CGO_LDFLAGS="-L/regex/target/release" && go build -buildvcs=false -ldflags "-s -w" -o benchmark .',
    #'Go Speedup'   => 'cd go/std_speedup && go get github.com/grafana/regexp@speedup && go build -ldflags "-s -w" -o ./benchmark .',
    'Go PCRE'      => 'cd go/pcre && go mod tidy && go build -buildvcs=false -ldflags "-s -w" -o benchmark .',
    'Go Re2'       => 'cd go/re2 && go mod tidy && go build -buildvcs=false -ldflags "-s -w"  -o benchmark .',
    'Go Regexp2'   => 'cd go/regexp2 && go mod tidy && go build -buildvcs=false -ldflags "-s -w" -o benchmark .',
    'Go'           => 'cd go/std && go build -buildvcs=false -ldflags "-s -w" -o benchmark .',
    'C PCRE2'      => 'gcc -O3 -DNDEBUG c/benchmark.c -I/usr/local/include/ -lpcre2-8 -o c/bin/benchmark',
    'Crystal'      => 'crystal build crystal/benchmark.cr --release -o crystal/bin/benchmark',
    'C++ STL'      => 'g++ -std=c++11 -O3 cpp/benchmark.cpp -o cpp/bin/benchmark-stl',
    'C++ Boost'    => 'g++ -std=c++11 -O3 cpp/benchmark.cpp -DUSE_BOOST -lboost_regex -o cpp/bin/benchmark-boost',
    'C++ SRELL'    => 'g++ -std=c++11 -O3 cpp/benchmark.cpp -DUSE_SRELL -o cpp/bin/benchmark-srell',
    'C# Mono'      => 'mcs csharp/Benchmark.cs -out:csharp/bin-mono/benchmark.exe -debug- -optimize',
    'C# .Net Core' => 'dotnet build csharp/benchmark.csproj -c Release',
    'D dmd'        => 'dmd -O -release -inline -of=d/bin/benchmark d/benchmark.d',
    'D ldc'        => 'ldc2 -O3 -release -of=d/bin/benchmark-ldc d/benchmark.d',
    'Dart Native'  => 'mkdir -p /var/regex/dart/bin && dart2native dart/benchmark.dart -o dart/bin/benchmark',
    'Java'         => 'javac java/Benchmark.java',
    'Kotlin'       => 'kotlinc kotlin/benchmark.kt -include-runtime -d kotlin/benchmark.jar',
    'Nim'          => 'nim c -d:release --opt:speed --verbosity:0 -o:nim/bin/benchmark nim/benchmark.nim',
    'Nim Regex'    => 'nim c -d:release --opt:speed --verbosity:0 -o:nim/bin/benchmark_regex nim/benchmark_regex.nim',
    'Rust'         => 'cargo build --quiet --release --manifest-path=rust/Cargo.toml',
];

const COMMANDS = [
    'Go Rure'           => 'export LD_LIBRARY_PATH="/regex/target/release" && go/rure/benchmark',
    'Go Regexp2'           => 'go/regexp2/benchmark',
    #'Go Speedup'           => 'go/std_speedup/benchmark',
    'Go PCRE'           => 'go/pcre/benchmark',
    'Go Re2'           => 'go/re2/benchmark',
    'Go'           => 'go/std/benchmark',
    'C PCRE2'      => 'c/bin/benchmark',
    'Crystal'      => 'crystal/bin/benchmark',
    'C++ STL'      => 'cpp/bin/benchmark-stl',
    'C++ Boost'    => 'cpp/bin/benchmark-boost',
    'C++ SRELL'    => 'cpp/bin/benchmark-srell',
    'C# Mono'      => 'mono -O=all csharp/bin-mono/benchmark.exe',
    'C# .Net Core' => 'dotnet csharp/bin/Release/net7.0/benchmark.dll',
    'D dmd'        => 'd/bin/benchmark',
    'D ldc'        => 'd/bin/benchmark-ldc',
    'Dart'         => 'dart dart/benchmark.dart',
    'Dart Native'  => 'dart/bin/benchmark',
    'Java'         => 'java -XX:+UnlockExperimentalVMOptions -XX:+UseEpsilonGC -classpath java Benchmark',
    'Javascript'   => 'node javascript/benchmark.js',
    'Julia'        => 'julia julia/benchmark.jl',
    'Kotlin'       => 'kotlin kotlin/benchmark.jar',
    'Nim'          => 'nim/bin/benchmark',
    'Nim Regex'    => 'nim/bin/benchmark_regex',
    'Perl'         => 'perl perl/benchmark.pl',
    'PHP'          => 'php php/benchmark.php',
    'Python 2'     => 'python2.7 python/benchmark.py',
    'Python 3'     => 'python3.10 python/benchmark.py',
    'Python PyPy2' => 'pypy2 python/benchmark.py',
    'Python PyPy3' => 'pypy3 python/benchmark.py',
    'Ruby'         => 'ruby ruby/benchmark.rb',
    'Rust'         => 'rust/target/release/benchmark',
];

echo '- Build' . PHP_EOL;

foreach (BUILDS as $language => $buildCmd) {
    shell_exec($buildCmd);

    echo $language . ' built.' . PHP_EOL;
}

echo PHP_EOL . '- Run' . PHP_EOL;

$results = [];

foreach (COMMANDS as $language => $command) {
    echo $language . ' running.';

    $currentResults = [];

    for ($i = 0; $i < RUN_TIMES; $i++) {
        $out = shell_exec($command . ' input-text.txt');
        preg_match_all('/^\d+\.\d+/m', $out, $matches);

        if (sizeof($matches[0]) === 0) {
            break;
        }

        for ($j = 0; $j < PATTERNS_COUNT; $j++) {
            $currentResults[$j][] = $matches[0][$j];
        }

        echo '.';
    }

    if (sizeof($currentResults) !== 0) {
        for ($i = 0; $i < PATTERNS_COUNT; $i++) {
            $results[$language][] = array_sum($currentResults[$i]) / count($currentResults[$i]);
        }

        $results[$language][PATTERNS_COUNT] = array_sum($results[$language]);
    }

    echo $language . ' ran.' . PHP_EOL;
}

echo PHP_EOL . '- Results' . PHP_EOL;

uasort($results, function ($a, $b) {
    return $a[PATTERNS_COUNT] < $b[PATTERNS_COUNT] ? -1 : 1;
});

$results = array_walk($results, function ($result, $language) {
    $result = array_map(function ($time) {
        return number_format($time, 2, '.', '');
    }, $result);

    if(str_contains($language, "Go")){
        echo '**<ins>' . $language . '</ins>** | ' . implode(' | ', $result) . PHP_EOL;
    } else {
        echo '**' . $language . '** | ' . implode(' | ', $result) . PHP_EOL;
    }

});
