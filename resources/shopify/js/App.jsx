import React, {Component} from 'react';
import { Route } from 'react-router-dom';
import { EmbeddedApp } from '@shopify/polaris/embedded';

import Dashboard from './Components/Dashboard'

import {
    Layout,
    Page,
    EmptyState,
    FooterHelp,
    Card,
    Link,
    Button,
    Banner,
    FormLayout,
    TextField
} from '@shopify/polaris';

class App extends Component
{
    componentDidMount() {

        // Shop does not have AP21 credentials yet
        if (! window.appConfig.hasAp21Credentials) {
            console.log(this.context);
        }

    }

    render() {
        return (
          <EmbeddedApp
            apiKey={window.appConfig.token}
            shopOrigin={window.appConfig.origin}
            forceRedirect>
              <div>
                  <Route path="/" component={Dashboard}/>
                  <FooterHelp>
                      <Link url="mailto:support@arkade.com.au" external>Contact Arkade</Link> for support
                  </FooterHelp>
              </div>
          </EmbeddedApp>
        );
    }
}

export default App;