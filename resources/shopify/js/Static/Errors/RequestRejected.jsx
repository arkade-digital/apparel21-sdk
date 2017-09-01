import React, { Component } from 'react';
import { Page, Banner, FooterHelp, Link } from '@shopify/polaris';

class RequestRejected extends Component {
    render() {
        return (
          <Page
            title="Apparel21 Syncer"
            separator
          >
              <Banner
                title="Request rejected"
                status="critical"
              >
                  <p>Your request was rejected for security reasons.</p>
              </Banner>
              <FooterHelp>
                  <Link url="mailto:support@arkade.com.au" external>Contact Arkade</Link> for support
              </FooterHelp>
          </Page>
        )
    }
}

export default RequestRejected;