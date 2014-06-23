package window

import (
	"../config"
	"syscall"
	"unsafe"
	"regexp"
	s "strings"
)

var (
	user = syscall.NewLazyDLL("user32.dll")
	procGetForegroundWindow = user.NewProc("GetForegroundWindow")
	procGetWindowText = user.NewProc("GetWindowTextW")
	procGetWindowTextLengthW = user.NewProc("GetWindowTextLengthW")
)

func GetForegroundTitle() (bool, string) {
	window, _, _ := procGetForegroundWindow.Call()

	textLength, _, _ := procGetWindowTextLengthW.Call(uintptr(window))
	textLength += 1

	titleBuffer := make([]uint16, textLength)
	procGetWindowText.Call(uintptr(window), uintptr(unsafe.Pointer(&titleBuffer[0])), textLength)

	title := syscall.UTF16ToString(titleBuffer)
	return IsValid(title), CleanTitle(title)
}

func IsValid(t string) bool {
	return s.Contains(t, config.Data.GetEditor()) && s.Contains(t, ".")
}

func CleanTitle(t string) string {
	r := regexp.MustCompile(`(\s•)?\s\(.*`)
	return r.ReplaceAllString(t, "")
}