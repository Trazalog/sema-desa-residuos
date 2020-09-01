package ar.gob.sanjuan.sads.tersu;

import gnu.io.*;
import gnu.io.CommPortIdentifier;
import gnu.io.PortInUseException;
import gnu.io.SerialPort;
import gnu.io.UnsupportedCommOperationException;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.PrintStream;
import java.util.Enumeration;

public class BasculaSerialPortConnector {

	public static void main(String[] args) {

		String wantedPortName = args[0];
		System.setProperty("gnu.io.rxtx.SerialPorts", wantedPortName);

		Enumeration portIdentifiers = CommPortIdentifier.getPortIdentifiers();
//
// Check each port identifier if
//   (a) it indicates a serial (not a parallel) port, and
//   (b) matches the desired name.
//
		CommPortIdentifier portId = null;  // will be set if port found
		while (portIdentifiers.hasMoreElements()) {
			CommPortIdentifier pid = (CommPortIdentifier) portIdentifiers.nextElement();
			if (pid.getPortType() == CommPortIdentifier.PORT_SERIAL &&
					pid.getName().equals(wantedPortName)) {
				portId = pid;
				break;
			}
		}
		if (portId == null) {
			System.err.println("Could not find serial port " + wantedPortName);
			System.exit(1);

		}

		//
		// Use port identifier for acquiring the port
		//

		SerialPort port = null;
		try {
			port = (SerialPort) portId.open(
					"name", // Name of the application asking for the port
					10000   // Wait max. 10 sec. to acquire port
			);
		} catch (PortInUseException e) {
			System.err.println("Port already in use: " + e);
			System.exit(1);
		}
//
// Now we are granted exclusive access to the particular serial
// port. We can configure it and obtain input and output streams.
//
		try {
			port.setSerialPortParams(
					115200,
					SerialPort.DATABITS_8,
					SerialPort.STOPBITS_1,
					SerialPort.PARITY_NONE);

		} catch (UnsupportedCommOperationException e) {
			e.printStackTrace();
		}

		// Open the input Reader and output stream. The choice of a
		// Reader and Stream are arbitrary and need to be adapted to
		// the actual application. Typically one would use Streams in
		// both directions, since they allow for binary data transfer,
		// not only character data transfer.
		//
		BufferedReader is;

		try {
			is = new BufferedReader(new InputStreamReader(port.getInputStream()));
		} catch (IOException e) {
			System.err.println("Can't open input stream: write-only");
			is = null;
		}

		// Imprimo el string recibido
		try {
			System.out.println(is.readLine());
		} catch (IOException e) {
			e.printStackTrace();
		}

		if (is != null) {
			try {
				is.close();
			} catch (IOException e) {
				e.printStackTrace();
			}
		}
		port.close();


	}
}

