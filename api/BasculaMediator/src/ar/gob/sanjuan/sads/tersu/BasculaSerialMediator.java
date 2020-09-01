package ar.gob.sanjuan.sads.tersu;

import gnu.io.*;
import org.apache.commons.logging.Log;
import org.apache.synapse.MessageContext;
import org.apache.synapse.mediators.AbstractMediator;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.util.Enumeration;

/**
 * Mediator que permite conectarse a una Báscula conectada al puerto serial
 * y tomar el peso actual que esat midiendo
 * @author rruiz - Trazalog
 * @date   25 jun 2020port
 */
public class BasculaSerialMediator extends AbstractMediator {

	private String portName;
	private Log log;
	private SerialPort port = null;

	public String getPortName() {
		return portName;
	}

	public void setPortName(String portName) {
		this.portName = portName;
	}

	/**
	 * Abre una instancia unica de puerto para recibir el peso
	 * @param mc
	 * @throws Exception
	 */
	public void openPort(MessageContext mc) throws Exception {
		log.info("Abriendo puerto serie " + portName);

		System.setProperty("gnu.io.rxtx.SerialPorts", portName);
		Enumeration portIdentifiers = CommPortIdentifier.getPortIdentifiers();

		CommPortIdentifier portId = null;  // will be set if port found
		while (portIdentifiers.hasMoreElements()) {
			CommPortIdentifier pid = (CommPortIdentifier) portIdentifiers.nextElement();

			log.debug("Leyendo port " + pid.toString());
			if (pid.getPortType() == CommPortIdentifier.PORT_SERIAL &&
					pid.getName().equals(portName)) {
				log.debug("el puerto seleccionado es " + pid.toString());
				portId = pid;
				break;
			}
		}
		if (portId == null) {
			log.error("Error intentando abrir puerto " + portName);
			throw new NoSuchPortException();

		}

		// Use port identifier for acquiring the port
		try {
			port = (SerialPort) portId.open(
					"tersu", // Name of the application asking for the port
					10000   // Wait max. 10 sec. to acquire port
			);
		} catch (PortInUseException e) {
			log.error("Puerto ya en uso: " + e);
			throw e;
		}

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
			log.error("Error configurando puerto: " + portName + ": " + e);
			throw e;
		}
	}

	/**
	 * Abre un InputStream esperando la trama que la báscula envia por el puerto en serie portName
	 * @param mc
	 * @return
	 */
	public boolean mediate(MessageContext mc) {
		try {
			log = mc.getServiceLog();
			BufferedReader is;

			//Si es la primer vez que nos conectamos, crea la conexión para el puerto
			if (port == null) {
				try {
					openPort(mc);
				} catch (Exception e) {
					log.error("Error abriendo puertos");
					throw e;
				}
			}

			//Leo el peso de la bascula
			try {
				is = new BufferedReader(new InputStreamReader(port.getInputStream()));
			} catch (IOException e) {
				log.error("No se puede abrir el input stream: solo escritura");
				is = null;
			}

			// obtengo el string recibido con el peso y lo seteo en la propiedad de wso2
			try {
				String trama = is.readLine();
				mc.setProperty("pesoBascula", trama);

				log.debug("Set property a mc, pesoBascula" + " = " + trama);
			} catch (IOException e) {
				log.error("Error recibiendo peso ");
				throw e;
			}

			// Finalizo la lectura
			if (is != null) {
				try {
					is.close();
				} catch (IOException e) {
					log.error("Error cerrando inputStream ");
					throw e;
				}
			}
		} catch (Exception e) {
			log.error("Imposible tomar peso",e);
			log.error(e);
		}
		return true;
	}
}



