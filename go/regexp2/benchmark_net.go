package main

import (
	"bytes"
	"fmt"
	"log"
	"os"
	"time"

	regexp "github.com/dlclark/regexp2"
)

func measure(data []rune, pattern string) {
	start := time.Now()

	r, err := regexp.Compile(pattern, 0)
	if err != nil {
		log.Fatal(err)
	}

	var matches [][]rune
	m, _ := r.FindRunesMatch(data)
	for m != nil {
		matches = append(matches, m.Runes())
		m, _ = r.FindNextMatch(m)
	}

	count := len(matches)

	elapsed := time.Since(start)

	fmt.Printf("%f - %v\n", float64(elapsed)/float64(time.Millisecond), count)
}

func main() {
	if len(os.Args) != 2 {
		fmt.Println("Usage: benchmark <filename>")
		os.Exit(1)
	}

	filerc, err := os.Open(os.Args[1])
	if err != nil {
		log.Fatal(err)
	}
	defer filerc.Close()

	buf := new(bytes.Buffer)
	buf.ReadFrom(filerc)
	data := bytes.Runes(buf.Bytes())

	// Email
	measure(data, `[\w\.+-]+@[\w\.-]+\.[\w\.-]+`)

	// URI
	measure(data, `[\w]+://[^/\s?#]+[^\s?#]+(?:\?[^\s#]*)?(?:#[^\s]*)?`)

	// IP
	measure(data, `(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9])\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9])`)

	// Named groups
	//measure(data, `(?P<email>[\w\.+-]+@[\w\.-]+\.[\w\.-]+)|(?P<uri>[\w]+://[^/\s?#]+[^\s?#]+(?:\?[^\s#]*)?(?:#[^\s]*)?)|(?P<ip>(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9])\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]))`)
}
