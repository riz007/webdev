import RPi.GPIO as io 
io.setmode(io.BOARD)
import sys, tty, termios, time
import serial
global char

led1_pin=16
led2_pin=18
led3_pin=22

io.setup(led1_pin, io.OUT)
io.setup(led2_pin, io.OUT)
io.setup(led3_pin, io.OUT)

port=serial.Serial("/dev/ttyAMA0", baudrate=115200, timeout=3.0)
def getch():
		fd = sys.stdin.fileno()
		old_settings=termios.tcgetattr(fd)
		try:
			tty.setraw(sys.stdin.fileno())
			ch=sys.stdin.read(1)
		finally:
			termios.tcsetattr(fd,termios.TCSADRAIN,old_settings)
		return ch

def zero():
		io.output(led1_pin, False)
		io.output(led2_pin, False)
		io.output(led3_pin, False)

def one():
		io.output(led1_pin, True)
		io.output(led2_pin, False)
		io.output(led3_pin, False)

def two():
		io.output(led1_pin, False)
		io.output(led2_pin, True)
		io.output(led3_pin, False)

def three():
		io.output(led1_pin, False)
		io.output(led2_pin, False)
		io.output(led3_pin, True)
def ON():
		io.output(led1_pin, True)
		io.output(led2_pin, True)
		io.output(led3_pin, True)
def OFF():
		io.output(led1_pin, False)
		io.output(led2_pin, False)
		io.output(led3_pin, False)
def BLINK():
		io.output(led1_pin, True)
		io.output(led2_pin, True)
		io.output(led3_pin, True)
		time.sleep(1)
		io.output(led1_pin, False)
		io.output(led2_pin, False)
		io.output(led3_pin, False)

io.output(led1_pin, False)
io.output(led2_pin, False)
io.output(led3_pin, False)

print("ENTER 1,2,3,ON,OFF,BLINK")
print("x: EXIT")

try:
	while True:
			global char
			char=getch()
			if(char=="0"):
				zero()
				port.write("0")
			if(char=="1"):
				one()
				port.write("1")
			if(char=="2"):
				two()
				port.write("2")
			if(char=="3"):
				three()
				port.write("3")
			if(char=="on"):
				ON()
				port.write("on")
			if(char=="off"):
				OFF()
				port.write("off")
			if(char=="blink"):
				BLINK()
				port.write("blink")
			if(char=="x"):
				exit()
				port.write("x")

except KeyboardInterrupt:
			GPIO.cleanup()
			print 'The application is exiting'
