// Iconos
      class Redes extends React.Component {
        render() {
          return <ul className="icons">
                        <li><a href="https://twitter.com/UMVirtual" className="icon alt fa-twitter"><span className="label">Twitter</span></a>
                        </li>
                        <li><a href="https://www.facebook.com/umvirtual" className="icon alt fa-facebook"><span className="label">Facebook</span></a>
                        </li>
                        <li><a href="mailto:umvirtual@um.edu.mx" className="icon alt fa-envelope"><span className="label">Email</span></a>
                        </li>
                    </ul>;
        }
      }
      
// Prueba
      class Prueba extends React.Component {
        render() {
            var today = new Date();
            var year = today.getFullYear();
            return <ul className="copyright">
                        <li>© <span>{year}</span> UM Virtual. Todos los derechos reservados</li>
                    </ul>;
            }
      }

// Prueba
      class Encabezado extends React.Component {
        render() {
            return <h2>para ser <br>+<br> productivo</h2>
                   <h3>Debes de ser saludable</h3>;
            }
      }

// Mount React Component (which uses WebComponent which uses React)
var container = document.getElementById('foot');
ReactDOM.render(<Redes />, container);
      
var hola = document.getElementById('copyright');
ReactDOM.render(<Prueba />, hola);

var head = document.getElementById('encabezado');
ReactDOM.render(<Encabezado />, head);

