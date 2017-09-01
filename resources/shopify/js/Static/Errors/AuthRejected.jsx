import React, { Component } from 'react';
import { Page, Banner, FooterHelp, Link } from '@shopify/polaris';

class AuthRejected extends Component {
    render() {
        return (
          <Page
            title="Apparel21 Syncer"
            separator
          >
              <Banner
                title="Installation failed"
                status="critical"
                action={{content: 'Try again', url: '/shopify/install'}}
              >
                  <p>We could not install into your Shopify store.</p>
              </Banner>
              <FooterHelp>
                  <Link url="mailto:support@arkade.com.au" external>Contact Arkade</Link> for support
              </FooterHelp>
          </Page>
        )
    }
}

export default AuthRejected;